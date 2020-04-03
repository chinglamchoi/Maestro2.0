@extends('layouts.app')

@section('content')
    @if(auth()->user()->type == 1 || auth()->user()->id == $course->user->id)
    <a href="/courses/{{$course->id}}/solution" class="btn btn-primary">View Solution</a><br/><br/>
    @endif
    @foreach($course->questions as $question)
    <?php
    if(isset($_GET['page'])) $page = $_GET['page']; else $page=1;
    $ans = auth()->user()->submissions->last()->answers->where('question_id', $question->id)->first()->answer;
    $a = ''; $b = ''; $c = ''; $d = '';
    if($ans == 1){$a = 'checked';}
    elseif($ans == 2){$b = 'checked';}
    elseif($ans == 3){$c = 'checked';}
    elseif($ans == 4){$d = 'checked';}
    ?>
    <h3>{{$course->name}}</h3>
    <small>Published on {{$course->updated_at}} by {{$course->user->name}}</small>
    <hr/>
    {{$course->questions->links()}}
    <div class="card">
        @if($question->ext)
        <img class="card-img-top" src="/storage/images/questions/{{$question->id}}.{{$question->ext}}" alt="Image">
        @endif
        <div class="card-body">
            <h4 class="card-title">{!!$question->question!!}</h4>
            {!! Form::open(['action' => ['CoursesController@save', $question->id], 'method' => 'POST']) !!}
            @csrf
            <div class="form-group card-text">
                <input onchange='this.form.submit();' type="radio" name="answer" id="A" value="1" class="radio" {{$a}}>
                <label for="A">A: {{$question->a}}</label><br/>
                <input onchange='this.form.submit();' type="radio" name="answer" id="B" value="2" class="radio" {{$b}}>
                <label for="B">B: {{$question->b}}</label><br/>
                <input onchange='this.form.submit();' type="radio" name="answer" id="C" value="3" class="radio" {{$c}}>
                <label for="C">C: {{$question->c}}</label><br/>
                <input onchange='this.form.submit();' type="radio" name="answer" id="D" value="4" class="radio" {{$d}}>
                <label for="D">D: {{$question->d}}</label>
            </div>
            <input name="page" type="hidden" value={{$page}}>
            {!! Form::close() !!}
        </div>
    </div>
    {{$course->questions->links()}}
    <hr/>
    <a href="/courses/submit" class="btn btn-success float-right">Submit</a>
    @endforeach
@endsection