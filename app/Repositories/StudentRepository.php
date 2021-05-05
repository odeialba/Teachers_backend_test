<?php namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class StudentRepository
{
    public function __construct()
    {
    }

    public function getStudentsByCourseId(int $courseId): array
    {
        return DB::table('users')
            ->join('course_registrations', function ($join) use ($courseId) {
                $join->on('users.id', '=', 'course_registrations.student_id')
                    ->where('course_registrations.course_id', '=', $courseId);
            })
            ->get('users.*')
            ->toArray();
    }
}