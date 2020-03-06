<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProfilesTest.php extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function a_user_has_a_profile()
    {
        $user = create('App\User');

        
        $this->get("/profiles/{{ $user->name }}")
        ->assertSee($user->name);
    }
}
