<?php namespace App\Services;

use App\Models\Course;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CourseService
{
    private VoteService $voteService;
    private TeacherService $teacherService;
    private StudentService $studentService;

    public function __construct(VoteService $voteService, TeacherService $teacherService, StudentService $studentService)
    {
        $this->voteService = $voteService;
        $this->teacherService = $teacherService;
        $this->studentService = $studentService;
    }

    /**
     * @return array<Course>
     */
    public function getAllCourses(): array
    {
        $courses = Course::query()->orderBy('name')->get('*');
        $allCourses = [];

        foreach ($courses->toArray() as $courseArray) {
            $course = (new Course())->fromArray($courseArray);
            $course->setVotes($this->voteService->getCourseVotes($course->getId()));
            $allCourses[] = $course;
        }

        return $allCourses;
    }

    /**
     * @return array<Course>
     */
    public function getAllCoursesByTeacherId(int $teacherId): array
    {
        $courses = DB::table('courses')
            ->join('course_teachers', function ($join) use ($teacherId) {
                $join->on('courses.id', '=', 'course_teachers.course_id')
                    ->where('course_teachers.teacher_id', '=', $teacherId);
            })
            ->get('courses.*');
        $allCourses = [];

        foreach ($courses->toArray() as $courseArray) {
            $course = (new Course())->fromArray($courseArray);
            $course->setTeachers($this->teacherService->getTeachersByCourseId($course->getId()));
            $course->setStudents($this->studentService->getStudentsByCourseId($course->getId()));

            $allCourses[] = $course;
        }

        return $allCourses;
    }

    /**
     * @return array<Course>
     */
    public function getAllCoursesByStudentId(int $studentId): array
    {
        $courses = DB::table('courses')
            ->join('course_registrations', function ($join) use ($studentId) {
                $join->on('courses.id', '=', 'course_registrations.course_id')
                    ->where('course_registrations.student_id', '=', $studentId);
            })
            ->get('courses.*');
        $allCourses = [];

        foreach ($courses->toArray() as $courseArray) {
            $course = (new Course())->fromArray($courseArray);
            $course->setTeachers($this->teacherService->getTeachersByCourseId($course->getId()));
            $course->setStudents($this->studentService->getStudentsByCourseId($course->getId()));

            $allCourses[] = $course;
        }

        return $allCourses;
    }

    public function getCourseByName(string $name): ?Course
    {
        $course = Course::query()->where('name', '=', $name)->first();

        return $this->buildCourseObject($course);
    }

    /*public function getCourseById(int $id): ?Course
    {
        $course = Course::query()->where('id', '=', $id)->first();

        return $this->buildCourseObject($course);
    }*/

    public function addTeacherToNewCourse(int $teacherId, string $courseName): bool
    {
        $course = $this->getCourseByName($courseName);

        if (! $course) {
            $courseId = $this->insertCourseByName($courseName);
        } else {
            $courseId = $course->getId();
        }

        return $this->addTeacherToCourse($teacherId, $courseId);
    }

    public function insertCourseByName(string $courseName): int
    {
        return DB::table('courses')->insertGetId(['name' => $courseName]);
    }

    public function addTeacherToCourse(int $teacherId, int $courseId): bool
    {
        return (bool) DB::table('course_teachers')->insertOrIgnore([
            [
                'course_id' => $courseId,
                'teacher_id' => $teacherId
            ],
        ]);
    }

    public function buildCourseObject(?Model $course): ?Course
    {
        return $course ? (new Course())->fromArray($course->toArray()) : null;
    }
}