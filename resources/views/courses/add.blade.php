@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <h1>Courses</h1>
            <div class="row">
                <div class="col-sm-12">
                    <form action="{{ route('courses') }}" method="post" enctype="multipart/form-data">
                    @csrf <!-- {{ csrf_field() }} -->
                        <div class="form-group">
                            <label class="h5" for="data">Course name:</label>
                            <input id="course" type="text" name="course" class="w-100 form-control" placeholder="New course name">
                        </div>
                        <button type="submit" name="add" class="btn btn-primary">Teach</button>
                    </form>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-sm-12">
                    <table class="table-hover table w-100">
                        <thead>
                        <tr class="bg-grey">
                            <th>Name</th><th>Votes</th><th></th><th></th>
                        </tr>
                        </thead>
                        @foreach ($courses as $course)
                            <?php /** @var \App\Models\Course $course */ ?>
                            <tr>
                                <td>{{ $course->getName() }}</td>
                                <td>{{ $course->getVotes() }}</td>
                                <td>
                                    <a href="{{ route('joinCourse', ['study', $course->getId()]) }}" class='btn btn-primary w-100 {{ in_array($course->getId(), $studyingCourseIds) ? 'disabled' : '' }}'>
                                        Study{{ in_array($course->getId(), $studyingCourseIds) ? 'ing' : '' }}
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('joinCourse', ['teach', $course->getId()]) }}" class='btn btn-primary w-100 {{ in_array($course->getId(), $teachingCourseIds) ? 'disabled' : '' }}'>
                                        Teach{{ in_array($course->getId(), $teachingCourseIds) ? 'ing' : '' }}
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