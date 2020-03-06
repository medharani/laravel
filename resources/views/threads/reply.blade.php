<div class="card card-default">
<div class="card-header">
	<div class="level">
                  <h5 class="flex">
                  <a href="#" >{{$reply->owner->name}}</a> said
                  {{$reply->created_at->diffForHumans()}}...
                  </h5>
                  <div>
                   {{ $reply->favorites()->count() }}
                  <form action ="POST" action ="/replies/{{$reply->id }}/favorites">
                  	@csrf
                  	<button type="submit" class="btn btn-primary" {{ $reply->isFavorited() ? 'disabled' : '' }}>

                  		{{$reply->favorites()->count()}} {{Str::plural('Favorite' , $reply->favorites()->count())}}</button>

                  </form>
              </div>
          </div>
      </div>
                <div class="card-body">
                  
                  {{$reply->body}}


                </div>
                <hr>

            </div>