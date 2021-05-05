@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-12">
            <h1>Votes</h1>
            <div class="row">
                <div class="col-sm-6">
                    <h2>Teachers</h2>
                    <table class="table-hover table w-100">
                        <thead>
                        <tr class="bg-grey">
                            <th>Name</th>
                            <th>Votes</th>
                            <th></th>
                        </tr>
                        </thead>
                        @foreach ($teachers as $teacher)
                            <?php /** @var \App\Models\Teacher $teacher */ ?>
                            <tr>
                                <td>{{ $teacher->getName() }}</td>
                                <td>{{ $teacher->getVotes() }}</td>
                                <td>
                                    <a href="{{ route('addVote', ['teacher', $teacher->getId()]) }}" class='btn btn-primary w-100 {{ in_array($teacher->getId(), $votedTeachers) ? 'disabled' : '' }}'>
                                        Vote{{ in_array($teacher->getId(), $votedTeachers) ? 'd' : '' }}
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                <div class="col-sm-6">
                    <h2>Courses</h2>
                    <table class="table-hover table w-100">
                        <thead>
                        <tr class="bg-grey">
                            <th>Name</th>
                            <th>Votes</th>
                            <th></th>
                        </tr>
                        </thead>
                        @foreach ($courses as $course)
                            <?php /** @var \App\Models\Course $course */ ?>
                            <tr>
                                <td>{{ $course->getName() }}</td>
                                <td>{{ $course->getVotes() }}</td>
                                <td>
                                    <a href="{{ route('addVote', ['course', $course->getId()]) }}" class='btn btn-primary w-100 {{ in_array($course->getId(), $votedCourses) ? 'disabled' : '' }}'>
                                        Vote{{ in_array($course->getId(), $votedCourses) ? 'd' : '' }}
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection