<?php

namespace Tests\Unit;

use App\Models\Teacher;
use PHPUnit\Framework\TestCase;

class TeacherTest extends TestCase
{
    public function test_buildTeacher()
    {
        $teacher = new Teacher();
        $teacher->setId(1);
        $teacher->setName('Teacher name');
        $teacher->setEmail('test@test.com');
        $teacher->setType('TEACHER');

        $dataArray = ['id' => 1, 'name' => 'Teacher name', 'email' => 'test@test.com', 'type' => 'TEACHER'];
        $this->assertEquals($teacher, (new Teacher())->fromObject((object) $dataArray));
    }
}
