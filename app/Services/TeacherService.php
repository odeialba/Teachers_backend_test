<?php namespace App\Services;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class TeacherService
{
    private VoteService $voteService;

    public function __construct(VoteService $voteService)
    {
        $this->voteService = $voteService;
    }

    /**
     * @return array<Teacher>
     */
    public function getAllTeachers(): array
    {
        $users = User::query()->where('type', '=', 'TEACHER')->orderBy('name')->get('*');
        $teachers = [];

        foreach ($users->toArray() as $user) {
            $teacher = (new Teacher())->fromArray($user);
            $teacher->setVotes($this->voteService->getTeacherVotes($teacher->getId()));
            $teachers[] = $teacher;
        }

        return $teachers;
    }

    /**
     * @return array<Teacher>
     */
    public function getTeachersByCourseId(int $courseId): array
    {
        $users = DB::table('users')
            ->join('course_teachers', function ($join) use ($courseId) {
                $join->on('users.id', '=', 'course_teachers.teacher_id')
                    ->where('course_teachers.course_id', '=', $courseId);
            })
            ->get('users.*');
        $teachers = [];

        foreach ($users->toArray() as $user) {
            $teachers[] = (new Teacher())->fromArray($user);
        }

        return $teachers;
    }
}