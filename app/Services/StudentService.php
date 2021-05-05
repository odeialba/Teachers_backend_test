<?php namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class StudentService
{
    public function __construct()
    {
    }

    /**
     * @return array<User>
     */
    public function getStudentsByCourseId(int $courseId): array
    {
        $users = DB::table('users')
            ->join('course_registrations', function ($join) use ($courseId) {
                $join->on('users.id', '=', 'course_registrations.student_id')
                    ->where('course_registrations.course_id', '=', $courseId);
            })
            ->get('users.*');
        $students = [];

        foreach ($users->toArray() as $user) {
            $students[] = (new User())->fromObject((object) $user);
        }

        return $students;
    }
}