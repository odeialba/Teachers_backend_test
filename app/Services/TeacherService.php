<?php namespace App\Services;

use App\Models\Teacher;
use App\Repositories\TeacherRepository;
use App\Repositories\VoteRepository;

class TeacherService
{
    private VoteRepository $voteRepository;
    private TeacherRepository $teacherRepository;

    public function __construct(VoteRepository $voteRepository, TeacherRepository $teacherRepository)
    {
        $this->voteRepository = $voteRepository;
        $this->teacherRepository = $teacherRepository;
    }

    /**
     * @return array<Teacher>
     */
    public function getAllTeachers(): array
    {
        $users = $this->teacherRepository->getAllTeachers();
        $teachers = [];

        foreach ($users as $user) {
            $teacher = (new Teacher())->fromObject((object) $user);
            $teacher->setVotes($this->voteRepository->getTeacherVotes($teacher->getId()));
            $teachers[] = $teacher;
        }

        return $teachers;
    }

    /**
     * @return array<Teacher>
     */
    public function getTeachersByCourseId(int $courseId): array
    {
        $users = $this->teacherRepository->getTeachersByCourseId($courseId);
        $teachers = [];

        foreach ($users as $user) {
            $teachers[] = (new Teacher())->fromObject((object) $user);
        }

        return $teachers;
    }
}