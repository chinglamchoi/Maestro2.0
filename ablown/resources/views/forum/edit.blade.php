@extends('layouts.app')

@section('content')
    <?php if(isset($_GET['page'])) $page = $_GET['page']; else $page=1;?>
    <a href='/posts' class='btn btn-light'>Back</a>
    <h3>{{$reply->topic->title}}</h3><br/>
    {!! Form::open(['action' => ['TopicsController@update', $reply->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
    <div class='form-group'>
        {{Form::textarea('body', $reply->body, ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'Body text'])}}
    </div>
    {{Form::hidden('_method', 'PUT')}}
    <input name="page" type="hidden" value={{$page}}>
    {{Form::submit('Edit Reply', ['class' => 'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection