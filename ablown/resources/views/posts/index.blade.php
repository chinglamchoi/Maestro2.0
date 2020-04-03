@extends('layouts.app')

@section('content')
    <h1>ABLOWN</h1>
    <a href='/posts/create' class='btn btn-primary'>New Post</a>
    @if(count($posts) > 0)
        @foreach($posts as $post)
        <div class="card my-2">
            <div class="row">
                <div class="col-md-4 col-sm-4">
                    <img style="width: 100%" src="/storage/cover_images/{{$post->cover_image}}"/>
                </div>
                <div class="col-md-4 col-sm-4">
                    <div class="card-body">
                        <h3 class="card-title"><a href="/posts/{{$post->id}}">{{$post->title}}</a></h3>
                        <small class="card-text">Written on {{$post->created_at}} by {{$post->user->name}}</small>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        {{$posts->links()}}
    @else
        <p>No posts found</p>
    @endif
@endsection