@extends('layouts.app')

@section('content')
    <div class="jumbotron text-center">
        <h1>{{$title}}</h1>
        @if(Auth::guest())
            <p>This is a website for autistic kids.</p>
            <p><a class="btn btn-primary btn-lg" href="/login" role="button">Login</a> <a class="btn btn-success btn-lg" href="/register" role="button">Register</a></p>
        @else
            <p>Welcome {{Auth::user()->name}}, what would you like to do today?</p>
            <a href="/forum" class="btn btn-primary">Chat</a>
            @if(Auth::user()->type == 1)
                <a href="/add" class="btn btn-primary">Add User</a>
            @endif
            @if(Auth::user()->type == 2)
            <a href="/users/{{Auth::user()->link}}" class="btn btn-primary">View Child</a>
            @endif
            @if(Auth::user()->type == 3)
                <a href="/users/{{Auth::user()->id}}" class="btn btn-primary">My Profile</a>
            @endif
            <a href="/courses" class="btn btn-primary">Courses</a>
        @endif
    </div>
@endsection