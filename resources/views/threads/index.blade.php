@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Forum threads</div>

                <div class="card-body">
                  @forelse($threads as $thread)
                  <article>
                  <h4 class="flex">
                   <a href="{{ $thread->path() }}" >
                    {{$thread->title}}
                   </a>
                </h4>
                <a href="{{$thread->path()}}">&nbsp;{{$thread->replies->count()}} &nbsp;<?php echo $plural = Str::plural('reply' , $thread->replies->count()); ?></a>
                  <div class="body">{{$thread->body}}</div>


                  </article>
                  <hr>
                  @empty

                  <p>There are no relavant results at this time.</p>
                  @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
