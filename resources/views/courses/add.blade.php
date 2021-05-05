@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <h1>Courses</h1>
            <div class="row">
                <div class="col-sm-12">
                    Form to add new course
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <table class="table-hover table w-100">
                        <thead>
                        <tr class="bg-grey">
                            <th>Id</th><th>Name</th><th></th>
                        </tr>
                        </thead>
                        @foreach ($courses as $course)
                            <?php /** @var \App\Models\Course $course */ ?>
                            <tr>
                                <td>{{ $course->getId() }}</td>
                                <td>{{ $course->getName() }}</td>
                                <td>Join as Teacher | Join as Student</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection