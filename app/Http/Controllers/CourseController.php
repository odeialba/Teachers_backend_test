<?php

namespace App\Http\Controllers;

use App\Services\CourseService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

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

    public function add(Request $request, CourseService $courseService): Renderable
    {
        if ($request->isMethod('POST')) {
            $teacherId = auth()->user()->__get('id');
            $courseName = (string) $request->get('course');

            $courseService->addTeacherToNewCourse($teacherId, $courseName);
        }

        $params = [
            'courses' => $courseService->getAllCourses(),
        ];

        return view('courses.add', $params);
    }
}
