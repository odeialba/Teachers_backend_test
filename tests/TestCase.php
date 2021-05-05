<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function loginWithFakeUser()
    {
        $user = new User([
            'id' => 1,
            'name' => 'Test user',
            'email' => 'test@test.com',
        ]);

        $this->be($user);
    }
}
