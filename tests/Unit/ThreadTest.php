<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ThreadTest extends TestCase
{
	use DatabaseMigrations;
    /**
     @test
     */
  function a_thread_has_replies()
    {
        $thread = factory('App\Thread')->create();

    	$this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $thread->replies);
    }
/**
     @test
     */

     function a_thread_can_make_a_string_path()
     {

        $thread = create('App\Thread');

        $this->assertEquals('/threads/' . $thread->channel->slug . '/' . $thread->id, $thread->path());
     } 

/**
     @test
     */

     function a_thread_can_make_a_string_path()
     {

        $thread = create('App\Thre');
       // $this->assertEquals('/threads/' . $thread->channel->slug . '/' .$thread->id, $thread->path());

        $this->assertEquals("/threads/{$thread->channel->slug}/{$thread->id}" , $thread->path());
     }



     /**
     @test
     */
    function a_thread_has_a_creator()
    {
         $thread = factory('App\Thread')->create();
         
         $this->assertInstanceOf('App\User', $thread->creator);
    }
/**
     @test
     */
    public function a_thread_can_add_a_reply(){
    	 $this->thread = factory('App\Thread')->create();
       
       $this->thread->addReply([
        'body' => 'Foobar',
        'user_id' =>1
       ]);

       $this->assertCount(1, $this->thread->replies);


    }

    /**
     @test
     */

     function a_thread_belongs_to_a_channel()
     {


        $thread = create('App\Thread');

        $this->assertInstanceOf('App\Channel' , $thread->channel);
     }

     function a_thread_can_be_subscribed_to()
     {

        $thread = create('App\Thread');

        $this->signIn();
        $thread->subscribe($userId = 1);

        $thread->subscriptions()->where('user_id', auth()->id())->get();
        //$user->subscribeToThread();
       // $user->subscriptions;
        $this->assertEquals(
            1, 
            $thread->subscriptions()->where('user_id' , $userId)->count());
     }

     /** @test */
     function a_thread_can_be_unsubscribed_form()
     {

        $thread = create('App\Thread');
        $thread->subscribe($userId =1);
        $thread->unsubscribe($userId);
     }
}
