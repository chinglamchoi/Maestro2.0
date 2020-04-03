@extends('layouts.app')

@section('content')
    <h1>Courses</h1>
    @if(auth()->user()->type < 3)
        <a href="/courses/create" class='btn btn-primary'>New Course</a>
    @endif
    <a href="/courses/submissions" class="btn btn-primary">Submissions</a>
    @if(count($courses) > 0)
        @foreach($courses as $course)
        <?php
        $submissions = $course->submissions->where('user_id', '==', auth()->user()->id);
        if(count($submissions) == 0){
            $class = '';
            $status = 'New Course';
        }else{
            $score = 0; $anss = $submissions->last()->answers;
            foreach($anss as $ans){
                if($ans->answer == $ans->question->answer){
                    $score++;
                }
            }
            $questions = count($course->questions);
            $class = 'bg-success';
            $status = 'Most Recent Score: '.$score.'/'.$questions;
        }
        ?>
        <div class="card my-2 {{$class}} ?>">
            <div class="card-body row">
                <div class="col-md-4 col-sm-4">
                    <h3 class="card-title"><a href="/courses/{{$course->id}}">{{$course->name}}</a></h3>
                    <small class="card-text">Created on {{$course->created_at}} by <a href="/users/{{$course->user->id}}">{{$course->user->name}}</a></small>
                </div>
                <div class="col-md-4 col-sm-4">
                    <h3>{{$status}}</h3>
                </div>
            </div>
        </div>
        @endforeach
        {{$courses->links()}}
    @else
        <p>No courses found</p>
    @endif
@endsection