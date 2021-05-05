<?php

namespace App\Http\Controllers;

use App\Services\CourseService;
use App\Services\TeacherService;
use App\Repositories\VoteRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(CourseService $courseService, TeacherService $teacherService, VoteRepository $voteRepository): Renderable
    {
        $userId = (int) auth()->user()->__get('id');
        $courses = $courseService->getAllCourses();
        $teachers = $teacherService->getAllTeachers();

        $votedTeachers = $voteRepository->getTeacherVotesByUserId($userId);
        $votedCourses = $voteRepository->getCourseVotesByUserId($userId);

        $params = [
            'courses' => $courses,
            'teachers' => $teachers,
            'votedTeachers' => $votedTeachers,
            'votedCourses' => $votedCourses,
        ];

        return view('votes.index', $params);
    }

    public function add(Request $request, VoteRepository $voteRepository): RedirectResponse
    {
        $id = (int) $request->route('id');
        $type = (string) $request->route('type');
        $userId = (int) auth()->user()->__get('id');

        if ($type === 'teacher') {
            $voteRepository->addVoteToTeacher($userId, $id);
        } elseif ($type === 'course') {
            $voteRepository->addVoteToCourse($userId, $id);
        }

        return redirect()->route('votes');
    }
}
