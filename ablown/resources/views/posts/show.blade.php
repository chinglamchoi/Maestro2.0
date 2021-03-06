@extends('layouts.app')

@section('content')
<a href='/posts' class='btn btn-light'>Back</a>
    <h1>{{$post->title}}</h1>
    <img style="width: 100%" src="/storage/cover_images/{{$post->cover_image}}"/>
    <br/><br/>
    <div class='my-2'>{!!$post->body!!}</div>
    <hr/>
    <small>Written on {{$post->created_at}} by {{$post->user->name}}</small>
    <hr/>
    @if(!Auth::guest())
        @if(Auth::user()->id == $post->user_id)
            <a href='/posts/{{$post->id}}/edit' class='btn btn-primary'>Edit</a>
        @endif
    @endif
@endsection