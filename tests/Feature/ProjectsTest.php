<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectsTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function a_user_can_create_a_project()
    {
      $attributes = [
       
       'title' => $this->fake->sentence,

      ];

    }
}
