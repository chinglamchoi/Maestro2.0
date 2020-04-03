@extends('layouts.app')

@section('content')
<a href="/courses" class="btn btn-secondary">Back</a>
<h3 class="text-center my-5">{{$course->name}}</h3>
<h1 class="text-center my-5">
    <a href="/courses/{{$course->id}}/start" class="btn btn-success">Start</a>
    @if(auth()->user()->type == 1 || auth()->user()->id == $course->user->id)
    <a href="/courses/{{$course->id}}/solution" class="btn btn-primary">View Solution</a><br/>
    @endif
</h1>
@endsection