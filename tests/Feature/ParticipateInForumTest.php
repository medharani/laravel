<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ParticipateInForum extends TestCase
{
    use DatabaseMigrations;
    /**
     @test
     */
     function an_unauthenticated_user_may_not_add_replies()
    {
         $this->expectException('Illuminate\Auth\AuthenticationException');

         $this->post('/threads/some-channel/1/replies' , [])

            ->assertRedirect('/login');
    }
    /**
     @test
     */
   function an_authenticated_user_may_participate_in_forum_threads()
    {
          //user
        $user = factory('App\User')->create();
        $this->be($user = factory('App\User')->create());
        //thread
         $thread = factory('App\Thread')->create();
        //reply
         $reply = factory('App\Reply')->create();
        $this->post($thread->path(). '/replies', $reply->toArray());

       $this->get($thread->path())->assertSee($reply->body);
    }
    /**
     @test
     */
     function a_reply_requires_a_body()
     {

        $this->withExceptionHandling()->signIn();

        $this->post($thread->path(). '/replies', $reply->toArray());
     }
}
