<?php

namespace App\Http\Controllers;

use App\Repositories\CourseRepository;
use App\Services\CourseService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(CourseService $courseService): Renderable
    {
        $userId = (int) auth()->user()->__get('id');
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
        $userId = (int) auth()->user()->__get('id');

        if ($request->isMethod('POST')) {
            $courseName = (string) $request->get('course');

            $courseService->addTeacherToNewCourse($userId, $courseName);
        }

        $studyingCourseIds = $courseService->getCoursesIdsByStudentId($userId);
        $teachingCourseIds = $courseService->getCoursesIdsByTeacherId($userId);

        $params = [
            'studyingCourseIds' => $studyingCourseIds,
            'teachingCourseIds' => $teachingCourseIds,
            'courses' => $courseService->getAllCourses(),
        ];

        return view('courses.add', $params);
    }

    public function join(Request $request, CourseRepository $courseRepository): RedirectResponse
    {
        $id = (int) $request->route('id');
        $type = (string) $request->route('type');
        $userId = (int) auth()->user()->__get('id');

        if ($type === 'teach') {
            $courseRepository->addTeacherToCourse($userId, $id);
        } elseif ($type === 'study') {
            $courseRepository->addStudentToCourse($userId, $id);
        }

        return redirect()->route('courses');
    }
}
