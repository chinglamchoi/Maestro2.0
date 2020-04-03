@extends('layouts.app')

@section('content')
    <a href="/courses" class="btn btn-secondary">Back</a><br/><br/>
    {!! Form::open(['action' => 'CoursesController@store', 'method' => 'POST']) !!}
    @csrf
    <div class='form-group'>
        {{Form::text('name', '', ['class' => 'form-control', 'placeholder' => 'CourseName'])}}
    </div>
    
    {{Form::submit('Create Course', ['class' => 'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection