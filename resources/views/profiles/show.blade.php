@extends('layouts.app')


@section('content')
<div class="page-heading">
	<h1>
{{ $profileUser->name }}
<small>Since {{ $profileUser->created_at->diffForHumans() }}</small>

</h1>
</div>
@foreach($activities as $activity)
<div class="panel panel=default">
<div class="panel-heading">
	<div class="level">
		<span class="flex">
			
		</span>
		<span>{{$thread->created_at->diffForHumans() }}</span>
	</div>
</div>	

</div>
@endsection