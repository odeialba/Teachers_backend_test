<?php

namespace Tests\Unit;

use App\Models\Course;
use PHPUnit\Framework\TestCase;

class CourseTest extends TestCase
{
    public function test_buildCourse()
    {
        $course = new Course();
        $course->setId(1);
        $course->setName('Course name');

        $this->assertEquals($course, (new Course())->fromObject((object) ['id' => 1, 'name' => 'Course name']));
    }
}
