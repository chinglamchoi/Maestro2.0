@extends('layouts.app')

@section('content')
<?php use Snipe\BanBuilder\CensorWords; $censor = new CensorWords;
if(isset($_GET['page'])) $page = $_GET['page']; else $page=1;?>
    <a href='/forum' class='btn btn-light'>Back</a><a href='/forum/create' class='btn btn-primary float-right'>New Topic</a>
    <h3>{{$censor->censorString($topic->title)['clean']}}</h3>
    <small>By <a href="/users/{{$topic->user->id}}">{{$topic->user->name}}</a></small><br/><br/>
    {{$topic->replies->links()}}
    @if(count($topic->replies) > 0)
        @foreach($topic->replies as $reply)
        <div class="card my-2">
            <div class="card-body row">
                <div class="col-md-4 col-sm-4">
                    <h5><a href="/users/{{$reply->user->id}}">{{$reply->user->name}}</a></h5>
                    <small>
                        @if($reply->user->type == 1)
                            Staff
                        @else
                            @if($reply->user->type == 2)
                                Parent
                            @else
                                Student
                            @endif
                        @endif
                    </small><br/>
                    <small class="card-text">Written on {{$reply->created_at}}</small>
                </div>
                <div class="col-md-4 col-sm-4">
                    {!!$censor->censorString($reply->body)['clean']!!}
                    @if($reply->updated_at != $reply->created_at)
                    <small class="card-text">Last edited on {{$reply->updated_at}}</small>
                    @endif
                    @if(Auth::user()->id == $reply->user_id)
                        <a href='/forum/{{$reply->id}}/edit?page={{$page}}' class='btn btn-primary'>Edit reply</a>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
        {{$topic->replies->links()}}
    @else
        <p>No replies found</p>
    @endif
    <br/>
    {!! Form::open(['action' => ['TopicsController@reply', $topic->id], 'method' => 'POST']) !!}
    <div class='form-group'>
        {{Form::textarea('body', '', ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'Body text'])}}
    </div>
    <input name="page" type="hidden" value={{$page}}>
    {{Form::submit('Reply', ['class' => 'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection