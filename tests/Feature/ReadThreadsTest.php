<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ReadThreadsTest extends TestCase
{
    use DatabaseMigrations;
    /**
   @test
     */
    public function a_user_can_browse_threads()
    {
        $thread = factory('App\Thread')->create();
        $response = $this->get('/threads');
        $response->assertSee($thread->title);

       

    }

    function a_user_can_read_a_single_thread()
    {

      $thread = factory('App\Thread')->create();
       $response = $this->get($thread->path())
       ->assertSee($thread->title);

    }

    function a_user_can_read_replies_that_are_associated_with_a_thread()
    {
        $thread = factory('App\Thread')->create();
          $reply = factory('App\Reply')->create(['thread_id' => $thread->id]);

          $this->get($thread->path())

           ->assertSee($reply->body);
    }

     /**
   @test
     */
   function a_user_can_filter_threads_according_to_a_channel()
   {

    $channel = create('App\Channel');

    $threadInChannel = create('App\Thread' , ['channel_id' =>$channel->id]);
    $threadNotInchannel = create('App\Thread');

    $this->get('/threads/' . $channel->slug)
         ->assertSee($threadInChannel->title)
         ->assertDontSee($threadNotInchannel->title);
   }
/**
   @test
     */
   function a_user_can_filter_threads_by_any_username()
   {

    $this->signIn(create('App\User' , ['name' => 'medharani']));

    $threadBymedha = create('App\Thread' , ['user_id' => auth()->id()]);
    $threadNotBymedha = create('App\Thread');

    $this->get('threads?by=medharani')
         ->assertSee($threadBymedha->title)
         ->assertDontSee($threadNotBymedha->title);


   }
   function a_user_can_filter_threads_by_popularity()
   {
    $threadWithTwoReplies = create('App\Thread');
    create('App\Reply' , ['thread_id' => $threadWithTwoReplies->id] , 2);

    $threadWithThreeReplies = create('App\Thread');
    create('App\Reply' , ['thread_id' => $threadWithThreeReplies->id] , 3);

    $threadWithNoReplies = $this->thread;


    $response = $this->getJson('threads?popularity=1')->json;

    $response->assertEquals([3, 2, 0] , array_column($response , 'replies_count'));

   }

}
