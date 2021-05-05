<?php namespace App\Repositories;

use App\Models\Course;
use Illuminate\Support\Facades\DB;

class CourseRepository
{
    public function __construct()
    {
    }

    public function getAllCourses(): array
    {
        return Course::query()
            ->orderBy('name')
            ->get('*')
            ->toArray();
    }

    public function getAllCoursesByTeacherId(int $teacherId): array
    {
        return DB::table('courses')
            ->join('course_teachers', function ($join) use ($teacherId) {
                $join->on('courses.id', '=', 'course_teachers.course_id')
                    ->where('course_teachers.teacher_id', '=', $teacherId);
            })
            ->get('courses.*')
            ->toArray();
    }

    public function getAllCoursesByStudentId(int $studentId): array
    {
        return DB::table('courses')
            ->join('course_registrations', function ($join) use ($studentId) {
                $join->on('courses.id', '=', 'course_registrations.course_id')
                    ->where('course_registrations.student_id', '=', $studentId);
            })
            ->get('courses.*')
            ->toArray();
    }

    public function getCourseByName(string $name): ?object
    {
        return Course::query()
            ->where('name', '=', $name)
            ->first();
    }

    public function insertCourseByName(string $courseName): int
    {
        return DB::table('courses')
            ->insertGetId(['name' => $courseName]);
    }

    public function addTeacherToCourse(int $teacherId, int $courseId): bool
    {
        return (bool) DB::table('course_teachers')
            ->insertOrIgnore([
                [
                    'course_id' => $courseId,
                    'teacher_id' => $teacherId
                ],
            ]);
    }

    public function addStudentToCourse(int $studentId, int $courseId): bool
    {
        return (bool) DB::table('course_registrations')
            ->insertOrIgnore([
                [
                    'course_id' => $courseId,
                    'student_id' => $studentId
                ],
            ]);
    }
}