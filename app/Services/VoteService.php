<?php namespace App\Services;

use Illuminate\Support\Facades\DB;

class VoteService
{
    public function __construct()
    {
    }

    public function getTeacherVotesByUserId(int $userId): array
    {
        return DB::table('teacher_votes')
            ->where('user_id', '=', $userId)
            ->pluck('teacher_id')
            ->toArray();
    }

    public function getCourseVotesByUserId(int $userId): array
    {
        return DB::table('course_votes')
            ->where('user_id', '=', $userId)
            ->pluck('course_id')
            ->toArray();
    }

    public function getTeacherVotes(int $teacherId): int
    {
        return DB::table('teacher_votes')
            ->where('teacher_id', '=', $teacherId)
            ->pluck('user_id')
            ->count();
    }

    public function getCourseVotes(int $courseId): int
    {
        return DB::table('course_votes')
            ->where('course_id', '=', $courseId)
            ->pluck('user_id')
            ->count();
    }

    public function addVoteToCourse(int $userId, int $courseId): void
    {
        DB::table('course_votes')->insertOrIgnore([
            'course_id' => $courseId,
            'user_id' => $userId
        ]);
    }

    public function addVoteToTeacher(int $userId, int $teacherId): void
    {
        DB::table('teacher_votes')->insertOrIgnore([
            'teacher_id' => $teacherId,
            'user_id' => $userId
        ]);
    }
}