@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-12">
            <h1>My courses</h1>
            <div class="row">
                <div class="col-sm-6">
                    <h2>As Teacher</h2>
                    <table class="table-hover table w-100">
                        <thead>
                        <tr class="bg-grey">
                            <th>Name</th>
                            <th>Teachers</th>
                            <th>Students</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($teachingCourses as $course)
                            <?php /** @var \App\Models\Course $course */ ?>
                            <tr>
                                <td>{{ $course->getName() }}</td>
                                <td>
                                    <ul>
                                        @foreach ($course->getTeachers() as $teacher)
                                            <?php /** @var \App\Models\Teacher $teacher */ ?>
                                            <li>{{ $teacher->getName() }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>
                                    <ul>
                                        @foreach ($course->getStudents() as $student)
                                            <?php /** @var \App\Models\User $student */ ?>
                                            <li>{{ $student->getName() }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-sm-6">
                    <h2>As Student</h2>
                    <table class="table-hover table w-100">
                        <thead>
                        <tr class="bg-grey">
                            <th>Name</th>
                            <th>Teachers</th>
                            <th>Students</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($studyingCourses as $course)
                            <?php /** @var \App\Models\Course $course */ ?>
                            <tr>
                                <td>{{ $course->getName() }}</td>
                                <td>
                                    <ul>
                                        @foreach ($course->getTeachers() as $teacher)
                                            <?php /** @var \App\Models\Teacher $teacher */ ?>
                                            <li>{{ $teacher->getName() }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>
                                    <ul>
                                        @foreach ($course->getStudents() as $student)
                                            <?php /** @var \App\Models\User $student */ ?>
                                            <li>{{ $student->getName() }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection