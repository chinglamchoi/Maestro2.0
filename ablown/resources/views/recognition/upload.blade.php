@extends('layouts.app')
@section('content')
    <h1>What is this person feeling?</h1>
    <p>Practice your emotion recognition skills! Enter a URL of a picture, and we will tell you how this person is feeling!</p>
    {!! Form::open(['action' => ['CoursesController@recognition'], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
    @csrf
    <div class='form-group'>
        {{Form::file('image')}}
    </div>
    {{Form::submit('Go!', ['class' => 'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection