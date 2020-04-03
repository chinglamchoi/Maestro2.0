@extends('layouts.app')

@section('content')
    <a href="/courses" class="btn btn-secondary">Back</a><br/><br/>
    <h3>Submissions</h3>
    @if(count($submissions) > 0)
        {{$submissions->links()}}
        <table class="table table-striped table-bordered table-hover">
            <tr>
                <th>Date / Time</th>
                <th>User</th>
                <th>Course</th>
                <th>Result</th>
                <th>Time</th>
            </tr>
        @foreach($submissions as $submission)
        <?php
            $score = 0; $text = ''; $bg = '';
            $full = count($submission->course->questions);
            foreach($submission->answers as $ans){
                if($ans->answer == $ans->question->answer){
                    $score++;
                }
            }
            if($score == $full){$text = 'text-success font-weight-bold';}
            if($submission->user->id == auth()->user()->id){$bg = 'mine';}
        ?>
        <tr class="{{$bg}}">
            <td><a href="/courses/submissions/{{$submission->id}}">{{$submission->updated_at}}</a></td>
            <td><a href="/users/{{$submission->user->id}}">{{$submission->user->name}}</a></td>
            <td><a href="/courses/{{$submission->course->id}}">{{$submission->course->name}}</a></td>
            <td class="{{$text}}">{{$score.'/'.$full}}</td>
            <td>{{$submission->updated_at->diffInSeconds($submission->created_at)}}s</td>
        </tr>
        @endforeach
        </table>
        {{$submissions->links()}}
    @else
        <p>No submissions found</p>
    @endif
@endsection