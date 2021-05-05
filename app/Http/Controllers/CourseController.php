<?php

namespace App\Http\Controllers;

use App\Services\CourseService;
use Illuminate\Contracts\Support\Renderable;

class CourseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(CourseService $courseService): Renderable
    {
        $userId = auth()->user()->__get('id');
        $studyingCourses = $courseService->getAllCoursesByStudentId($userId);
        $teachingCourses = $courseService->getAllCoursesByTeacherId($userId);

        $params = [
            'studyingCourses' => $studyingCourses,
            'teachingCourses' => $teachingCourses,
        ];

        return view('courses.index', $params);
    }

    public function add(CourseService $courseService): Renderable
    {
        $courses = $courseService->getAllCourses();

        $params = [
            'courses' => $courses,
        ];

        return view('courses.add', $params);
        // I will add an input to insert the name for a new course and a button to join as teacher
        // (if there is no course, it doesn't make sense to join as student)
        // Then I will add a list of existing courses and two buttons. One to join as student and one to join as teacher.
    }
}
