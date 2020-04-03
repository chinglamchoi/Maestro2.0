@extends('layouts.app')

@section('content')
<a href='/forum' class='btn btn-light'>Back</a>
    <h1>New Topic</h1>
    {!! Form::open(['action' => 'TopicsController@store', 'method' => 'POST']) !!}
    <div class='form-group'>
        {{Form::label('title', 'Title')}}
        {{Form::text('title', '', ['class' => 'form-control', 'placeholder' => 'Title'])}}
    </div>
    <div class='form-group'>
        {{Form::label('body', 'Body')}}
        {{Form::textarea('body', '', ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'Body text'])}}
    </div>
    {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection