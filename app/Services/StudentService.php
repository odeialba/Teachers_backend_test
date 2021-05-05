<?php namespace App\Services;

use App\Models\User;
use App\Repositories\StudentRepository;

class StudentService
{
    private StudentRepository $studentRepository;

    public function __construct(StudentRepository $studentRepository)
    {
        $this->studentRepository = $studentRepository;
    }

    /**
     * @return array<User>
     */
    public function getStudentsByCourseId(int $courseId): array
    {
        $users = $this->studentRepository->getStudentsByCourseId($courseId);
        $students = [];

        foreach ($users as $user) {
            $students[] = (new User())->fromObject((object) $user);
        }

        return $students;
    }
}