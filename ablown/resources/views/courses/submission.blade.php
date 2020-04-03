@extends('layouts.app')

@section('content')
    <?php
        $score = 0; $text = '';
        $full = count($submission->answers);
        foreach($submission->answers as $ans){
            if($ans->answer == $ans->question->answer){
                $score++;
            }
        }
        if($score == $full){$text = 'text-success font-weight-bold';}
    ?>
    <a href="/courses" class="btn btn-secondary">Back</a><br/><br/>
    <h1>Submission {{$submission->id}}</h1>
    <div class="btn-group">
        <a href="#" class="btn btn-outline-secondary btn-responsive disabled">{{$submission->updated_at}}</a>
        <a href="/users/{{$submission->user->id}}" class="btn btn-outline-secondary btn-responsive">{{$submission->user->name}}</a>
        <a href="/courses/{{$submission->course->id}}" class="btn btn-outline-secondary btn-responsive">{{$submission->course->name}}</a>
    </div>
    <div class="btn-group">
        <a href="#" class="btn btn-outline-secondary btn-responsive disabled {{$text}}">{{$score.'/'.$full}}</a>
        <a href="#" class="btn btn-outline-secondary btn-responsive disabled">Score: {{$score * 100 / $full}}</a>
    </div><br/><br/>
    <h2>Results</h2>
    @if(count($submission->answers) > 0)
        {{$submission->answers->links()}}
        <table class="table table-striped table-bordered table-hover">
            <tr>
                <th>Question</th>
                <th>Your Answer</th>
                <th>Result</th>
                <th>Time Taken</th>
            </tr>
        @foreach($submission->answers as $answer)
        <?php
            if($answer->answer == $answer->question->answer){
                $result = '<td class="text-success font-weight-bold">Accepted</td>';
            }else{
                $result = '<td>Wrong Answer</td>';
            }
            if($answer->answer == 1){
                $yourAns = '<td>A. '.$answer->question->a.'</td>';
            }elseif($answer->answer == 2){
                $yourAns = '<td>B. '.$answer->question->b.'</td>';
            }elseif($answer->answer == 3){
                $yourAns = '<td>C. '.$answer->question->c.'</td>';
            }elseif($answer->answer == 4){
                $yourAns = '<td>D. '.$answer->question->d.'</td>';
            }else{
                $yourAns = '<td class="text-muted">No answer</td>';
            }
        ?>
        <tr>
            <td>{!!$answer->question->question!!}</td>
            {!!$yourAns!!}
            {!!$result!!}
            <td>{{$answer->updated_at->diffInSeconds($submission->created_at)}}s</td>
        </tr>
        @endforeach
        </table>
        {{$submission->answers->links()}}
    @else
        <p>No answers found</p>
    @endif
@endsection