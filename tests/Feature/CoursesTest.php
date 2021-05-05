<?php

namespace Tests\Feature;

use Tests\TestCase;

class CoursesTest extends TestCase
{
    public function test_redirectJoinToCourse()
    {
        $this->loginWithFakeUser();

        $response = $this->get('/join-course/study/5');
        $response->assertStatus(302);
        $response->assertRedirect('/courses');
    }

    public function test_redirectTeachCourse()
    {
        $this->loginWithFakeUser();

        $response = $this->get('/join-course/teach/5');
        $response->assertStatus(302);
        $response->assertRedirect('/courses');
    }
}
