@extends('layouts.app')

@section('content')
    <a href="/courses" class="btn btn-secondary">Back</a><br/><br/>
    <h3>{{$course->name}}</h3>
    <small>Published on {{$course->updated_at}} by {{$course->user->name}}</small>
    <hr/>
    @foreach($course->questions as $question)
    <div class="card">
        @if($question->ext)
        <img class="card-img-top" src="/storage/images/questions/{{$question->id}}.{{$question->ext}}" alt="Image"/>
        @endif
        <div class="card-body">
            <h4 class="card-title">{!!$question->question!!}</h4>
            <div class="card-text">
                <p>A: {{$question->a}}</p>
                <p>B: {{$question->b}}</p>
                <p>C: {{$question->c}}</p>
                <p>D: {{$question->d}}</p>
                <p>Answer: {{chr($question->answer + 64)}}</p>
            </div>
        </div>
    </div>
    <hr/>
    @endforeach
    {{$course->questions->links()}}
@endsection