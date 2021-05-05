<?php namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class TeacherRepository
{
    public function __construct()
    {
    }

    public function getAllTeachers(): array
    {
        return User::query()
            ->where('type', '=', 'TEACHER')
            ->orderBy('name')->get('*')
            ->toArray();
    }

    public function getTeachersByCourseId(int $courseId): array
    {
        return DB::table('users')
            ->join('course_teachers', function ($join) use ($courseId) {
                $join->on('users.id', '=', 'course_teachers.teacher_id')
                    ->where('course_teachers.course_id', '=', $courseId);
            })
            ->get('users.*')
            ->toArray();
    }
}