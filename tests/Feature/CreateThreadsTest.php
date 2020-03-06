<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;


class CreateThreadsTest extends TestCase
{
    use DatabaseMigrations;
    /**
     @test
     
     */
      function guests_may_not_create_threads()
      {
         $this->expectException('Illuminate\Auth\AuthenticationException');
          $this->get('/threads/create')
         ->assertRedirect('/login');
         //$thread = make('App\Thread');

          $this->post('/threads', $thread->toArray());

      }


     /**
     @test
     
     */
     function an_authenticated_user_can_create_new_forum_threads()
    {
      
       
      $this->signIn();

      $thread = make('App\Thread');

      $response = $this->post('/threads', $thread->toArray());

      $this->get($response->headers->get('Location'))
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
    /**
     @test
     
     */
     function a_thread_requires_a_title()
     {
       
       $this->publishThread(['title' =>null])
            ->assertSessionHasErrors('title');

          }
           /**
     @test
     
     */
 function a_thread_requires_a_body()
     {
       
       $this->publishThread(['body' =>null])
            ->assertSessionHasErrors('body');

          }
 /**
     @test
     
     */
           function a_thread_requires_a_valid_channel()
     {
         
        factory('App\Channel' , 2)->create();

       $this->publishThread(['channel_id' =>null])
            ->assertSessionHasErrors('channel_id');

          }

          function unauthorized_users_may_not_deleted_threads()
          {

            $this->signIn();
            $thread = create('App\Thread');
            $reply = create('App\Reply' , ['thread_id' => $thread->id]);

            $response = $this->json('DELETE' , $thread->path());

            $response->assertStatus(204);

            $this->assertDatabaseMissing('threads' , ['id' => $thread->id]);
             $this->assertDatabaseMissing('replies' , ['id' => $reply->id]);

             $this->assertDatabaseMissing('activities' , [
                
                'subject_id' => $thread->id,
                'subject_type' => get_class($thread)

             ]);
             $this->assertDatabaseMissing('activities' , [
                
                'subject_id' => $reply->id,
                'subject_type' => get_class($reply)

             ]);
          }


    public function publishThread($overrides = []){

      $this->withExceptionHandling()->signIn();
      $thread = make('App\Thread' , $overrides);

      $this->post('/threads' , $thread->toArray());
     }
}
