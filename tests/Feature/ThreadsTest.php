<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ThreadsTest extends TestCase
{
    use DatabaseMigrations;
    /**
   @test
     */


 
    public function a_user_can_browse_threads()
    {
        $this->thread = factory('App\Thread')->create();
        $response = $this->get('/threads');
        $response->assertSee($this->thread->title);

       

    }

    function a_user_can_read_a_single_thread()
    {

    $this->thread = factory('App\Thread')->create();
       $response = $this->get('/threads/' . $this->thread->id);
         $response->assertSee($this->thread->title);

    }

    function a_user_can_read_replies_that_are_associated_with_a_thread()
    {
         $thread = factory('App\Thread')->create();
          factory('App\Reply')->create(['thread_id' => $thread->id]);
    }
}
