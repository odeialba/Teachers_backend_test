<?php

namespace App\Http\Controllers;

use App\Services\CourseService;
use App\Services\TeacherService;
use App\Services\VoteService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(CourseService $courseService, TeacherService $teacherService, VoteService $voteService): Renderable
    {
        $courses = $courseService->getAllCourses();
        $teachers = $teacherService->getAllTeachers();

        $votedTeachers = $voteService->getTeacherVotesByUserId(auth()->user()->__get('id'));
        $votedCourses = $voteService->getCourseVotesByUserId(auth()->user()->__get('id'));

        $params = [
            'courses' => $courses,
            'teachers' => $teachers,
            'votedTeachers' => $votedTeachers,
            'votedCourses' => $votedCourses,
        ];

        return view('votes.index', $params);
    }

    public function add(Request $request, VoteService $voteService): RedirectResponse
    {
        $id = (int) $request->route('id');
        $type = (string) $request->route('type');

        if ($type === 'teacher') {
            $voteService->addVoteToTeacher(auth()->user()->__get('id'), $id);
        } elseif ($type === 'course') {
            $voteService->addVoteToCourse(auth()->user()->__get('id'), $id);
        }

        return redirect()->route('votes');
    }
}
