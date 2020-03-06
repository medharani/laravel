<?php

namespace App\Http\Controllers;
use App\Channel;
use App\Thread;
use Illuminate\Http\Request;


class ThreadsController extends Controller
{
/**
     * ThreadsController constructor.
   
     */

    public function __construct()
{

    $this->middleware('auth')->except(['index','show']);
}
    public function index(Channel $channel)
    {

        if($channel->exists){

        // $channelId = Channel::where('slug' , $channelSlug)->first()->id;   
        $threads = $channel->threads()->latest();

        }
        else
        {
        $threads = Thread::latest();

        }
        if($username = request('by')){
            $user = \App\User::where('name' , $username)->firstorFail();
            $threads->where('user_id' , $user->id);
        }
         $threads = $threads->get();
        return view('threads.index' , compact('threads'));
    }

    
    public function create()
    {
        //dd("hello");
        return view('threads.create');
    }

 
    public function store(Request $request)
    {
      //dd($request->all());
       $this->validate($request, [
          
          'title' => 'required',
          'body' => 'required',
          'channel_id' =>'required|exists:channels,id'

       ]);


       $thread = Thread::create([
             'user_id' =>auth()->id(),
             'channel_id' =>request('channel_id'),
             'title' =>request('title'),
             'body' =>request('body')


       ]);
       return redirect($thread->path());
    }

    
    public function show($channel , Thread $thread)
    {
      // return $thread->replies;
       return view('threads.show', [
        'thread' => $thread,
        'replies' => $thread->replies()->paginate(1) 

       ]);
    }

    
    public function edit(Thread $thread)
    {
        //
    }

    
    public function update(Request $request, Thread $thread)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function destroy($channel, Thread $thread)
    {
      $this->authorize('update' ,$thread);
      $thread->replies()->delete();
        $thread->delete();
      if(request()->wantsJson())
      {
        return response([] , 204);
      }
      return redirect('/threads');
    }

    protected function getThreads(Channel $channel )
    {

      if($channel->exists)
      {
        $threads = $channel->threads->latest();
      } else {
        $threads = Thread::latest();
      }

      if($username = request('by')){

        $user =\App\User::where('name' , $username)->firstorFail();


        $threads->where('user_id' , $user->id);
      }

      $threads = $threads->get();
      return $threads;
 
    }
}
