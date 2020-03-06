@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create a new threads</div>

                <div class="card-body">
                  <form action="/threads" method="post">
                    @csrf
                     <div class="form-group">
                      <label for="channel_id">Choose a channel:  </label>
                      <select name="channel_id" class="form-control" id="channel_id" required>
                        @foreach($channels as $channel)
                         <option value="{{$channel->id}}" {{ old('channel_id') == $channel->id ? 'selected' : ''}}>{{$channel->name}}</option>
                        @endforeach
                       </select>
                    </div>
                    <div class="form-group">
                      <label for="title">Title:  </label>
                      <input type="text" name="title" class="form-control" id="title" placeholder="title" value="{{old('title')}}" required>

                    </div>
                     <div class="form-group">
                      <label for="body">Body:  </label>
                      <textarea  name="body" class="form-control" id="body" placeholder="" rows="8" required>
                      </textarea>
                    </div>
                     
                     <button type="submit" class="btn btn-primary">Publish</button>

                  </form>
                  @if(count($errors))
                  <ul>
                    @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                    @endforeach
                  </ul>



                  @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
