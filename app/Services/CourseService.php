<?php namespace App\Services;

use App\Models\Course;
use App\Repositories\CourseRepository;
use App\Repositories\VoteRepository;

class CourseService
{
    private VoteRepository $voteRepository;
    private CourseRepository $courseRepository;
    private TeacherService $teacherService;
    private StudentService $studentService;

    public function __construct(
        VoteRepository $voteRepository,
        CourseRepository $courseRepository,
        TeacherService $teacherService,
        StudentService $studentService
    ) {
        $this->voteRepository = $voteRepository;
        $this->courseRepository = $courseRepository;
        $this->teacherService = $teacherService;
        $this->studentService = $studentService;
    }

    /**
     * @return array<Course>
     */
    public function getAllCourses(): array
    {
        $courses = $this->courseRepository->getAllCourses();
        $allCourses = [];

        foreach ($courses as $courseObj) {
            $course = (new Course())->fromObject((object) $courseObj);
            $course->setVotes($this->voteRepository->getCourseVotes($course->getId()));
            $allCourses[] = $course;
        }

        return $allCourses;
    }

    /**
     * @return array<Course>
     */
    public function getAllCoursesByTeacherId(int $teacherId): array
    {
        $courses = $this->courseRepository->getAllCoursesByTeacherId($teacherId);
        $allCourses = [];

        foreach ($courses as $courseObj) {
            $course = (new Course())->fromObject((object) $courseObj);
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
        $courses = $this->courseRepository->getAllCoursesByStudentId($studentId);
        $allCourses = [];

        foreach ($courses as $courseObj) {
            $course = (new Course())->fromObject((object) $courseObj);
            $course->setTeachers($this->teacherService->getTeachersByCourseId($course->getId()));
            $course->setStudents($this->studentService->getStudentsByCourseId($course->getId()));

            $allCourses[] = $course;
        }

        return $allCourses;
    }

    public function getCoursesIdsByStudentId(int $studentId): array
    {
        $courses = $this->getAllCoursesByStudentId($studentId);

        return $this->getCoursesIdsFromCourses($courses);
    }

    public function getCoursesIdsByTeacherId(int $teacherId): array
    {
        $courses = $this->getAllCoursesByTeacherId($teacherId);

        return $this->getCoursesIdsFromCourses($courses);
    }

    /**
     * @param Course[] $courses
     * @return int[]
     */
    private function getCoursesIdsFromCourses(array $courses): array
    {
        $courseIds = [];

        foreach ($courses as $course) {
            $courseIds[] = $course->getId();
        }

        return $courseIds;
    }

    public function getCourseByName(string $name): ?Course
    {
        $course = $this->courseRepository->getCourseByName($name);

        return $course ? (new Course())->fromObject((object) $course->toArray()) : null;
    }

    public function addTeacherToNewCourse(int $teacherId, string $courseName): bool
    {
        $course = $this->getCourseByName($courseName);

        if (! $course) {
            $courseId = $this->courseRepository->insertCourseByName($courseName);
        } else {
            $courseId = $course->getId();
        }

        return $this->courseRepository->addTeacherToCourse($teacherId, $courseId);
    }
}