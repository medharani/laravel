@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                <a href="#">{{$thread->creator->name}}</a> posted:

                  {{$thread->title}}


                </div>
               @can('update' , $thread)
               <form method="POST" action ="{{ $thread->path()}}">
               @csrf {{method_field('DELETE')}}
               <button type="submit" class="btn btn-link">Delete Thread</button>


               </form>
               @endcan
                <div class="card-body">
                  
                  {{$thread->body}}


                </div>
            </div>
        </div>
    </div>
  
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                @foreach($replies as $reply)
                @include('threads.reply')
                @endforeach

                {{$replies->links()}}
            </div>
        </div>
    </div>

      @if(auth()->check())
     <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
               <form method="post" action ="{{$thread->path(). '/replies'}}">
                @csrf
                <div class="form-body">
                   <textarea name="body" id ="body" class="form-control" placeholder ="Have something to say ?" rows="5"> </textarea>
                   

              </div> 
               <input  type="submit" class="btn btn-default" name="post" style="background-color: green; color:white;">



               </form>
            </div>
        </div>
    </div>
    @else 
    <p>Please <a href="{{route('login')}}" class="text-center">sign in</a>participate in this discussion</p>
    @endif
</div>
<div class="col-md-4">
  <div class="panel panel-default">
    <div class="panel-body">
      <p>
        This thread was published {{$thread->created_at->diffForHumans()}}
        <a href="#">{{$thread->creator->name}}</a> and currently has {{$thread->replies->count()}} comments.
      </p>


    </div>



  </div>




</div>
@endsection
