<?php

namespace Tests\Feature;

use Tests\TestCase;

class VotesTest extends TestCase
{
    public function test_redirectAddVoteCourse()
    {
        $this->loginWithFakeUser();

        $response = $this->get('/vote/course/5');
        $response->assertStatus(302);
        $response->assertRedirect('/votes');
    }

    public function test_redirectAddVoteTeacher()
    {
        $this->loginWithFakeUser();

        $response = $this->get('/vote/teacher/5');
        $response->assertStatus(302);
        $response->assertRedirect('/votes');
    }
}
