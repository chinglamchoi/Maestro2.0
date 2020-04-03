@extends('layouts.app')

@section('content')
    <a href="/courses/{{$course->id}}/publish" class="btn btn-primary">Publish</a><br/><br/>
    <h3>{{$course->name}}</h3>
    @if(count($course->questions) > 0)
        {{$course->questions->links()}}
        @foreach($course->questions as $question)
        <div class="card my-2">
            <div class="card-body">
                <p>{!!$question->question!!}</p>
                <p>A: {!!$question->a!!}</p>
                <p>B: {!!$question->b!!}</p>
                <p>C: {!!$question->c!!}</p>
                <p>D: {!!$question->d!!}</p>
                <p>Answer: {{chr($question->answer + 64)}}</p>
            </div>
        </div>
        @endforeach
        {{$course->questions->links()}}
    @else
        <p>No questions found</p>
    @endif
    <br/>
    {!! Form::open(['action' => ['CoursesController@question', $course->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
    @csrf
    <div class='form-group'>
        {{Form::label('question', 'Question')}}
        {{Form::textarea('question', '', ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'Question'])}}
    </div>
    <div class='form-group'>
        {{Form::label('image', 'Image (optional)')}}
        {{Form::file('image')}}
    </div>
    <div class='form-group'>
        {{Form::label('a', 'A')}}
        {{Form::text('a', '', ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'A'])}}
    </div>
    <div class='form-group'>
        {{Form::label('b', 'B')}}
        {{Form::text('b', '', ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'B'])}}
    </div>
    <div class='form-group'>
        {{Form::label('c', 'C')}}
        {{Form::text('c', '', ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'C'])}}
    </div>
    <div class='form-group'>
        {{Form::label('d', 'D')}}
        {{Form::text('d', '', ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'D'])}}
    </div>
    <div class='form-group'>
        {{Form::label('correct_answer', 'Correct Answer:')}}<br/>
        <label for="A">A</label>
        <input type="radio" name="answer" id="A" value="1" class="radio">
        <label for="B">B</label>
        <input type="radio" name="answer" id="B" value="2" class="radio">
        <label for="C">C</label>
        <input type="radio" name="answer" id="C" value="3" class="radio">
        <label for="D">D</label>
        <input type="radio" name="answer" id="D" value="4" class="radio">
    </div>
    {{Form::submit('Add question', ['class' => 'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection