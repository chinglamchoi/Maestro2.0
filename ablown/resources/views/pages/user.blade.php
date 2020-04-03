@extends('layouts.app')

@section('content')
<?php use Snipe\BanBuilder\CensorWords; $censor = new CensorWords; ?>
    <h1>{{$user->name}}</h1>
    <hr/>
    <h3>About:</h3>
    <div id="about">{!!$censor->censorString($user->about)['clean']!!}</div>
    @if($user->id == auth()->user()->id)
        <div id="editabout" style="display: none">
            {!! Form::open(['action' => ['PagesController@userabout', $user->id], 'method' => 'POST']) !!}
            <div class='form-group'>
                {{Form::textarea('about', $user->about, ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'About'])}}
            </div>
            {{Form::submit('Save', ['class' => 'btn btn-primary'])}}
            {!! Form::close() !!}
        </div>
        <br/>
        <script type="text/javascript">
            function toggleA() {
                var about = document.getElementById("about");
                var edit = document.getElementById("editabout");
                if(edit.style.display === "none"){
                    about.style.display = "none";
                    edit.style.display = "block";
                }else{
                    about.style.display = "block";
                    edit.style.display = "none";
                }
            }
            function toggleI() {
                var interests = document.getElementById("interests");
                var edit = document.getElementById("editinterests");
                if(edit.style.display === "none"){
                    interests.style.display = "none";
                    edit.style.display = "block";
                }else{
                    interests.style.display = "block";
                    edit.style.display = "none";
                }
            }
        </script>
        <button class="btn btn-primary" onclick="toggleA()">Edit</button>
    @endif
    <hr/>
    <h3>Interests:</h3>
    <div id="interests">
        <ul>
            @if($user->cars)
            <li>Cars</li>
            @endif
            @if($user->food)
            <li>Food</li>
            @endif
            @if($user->math)
            <li>Math</li>
            @endif
            @if($user->animals)
            <li>Animals</li>
            @endif
            @if($user->books)
            <li>Books</li>
            @endif
        </ul>
    </div>
    @if($user->id == auth()->user()->id)
        <div id="editinterests" style="display: none">
            {!! Form::open(['action' => ['PagesController@userinterests', $user->id], 'method' => 'POST']) !!}
            <div class='form-group'>
                <h5>Cars: 
                    @if($user->cars)
                    {{Form::checkbox('cars', 1, true)}}
                    @else
                    {{Form::checkbox('cars', 1)}}
                    @endif
                </h5>
                <h5>Food: 
                    @if($user->food)
                    {{Form::checkbox('food', 1, true)}}
                    @else
                    {{Form::checkbox('food', 1)}}
                    @endif
                </h5>
                <h5>Math: 
                    @if($user->math)
                    {{Form::checkbox('math', 1, true)}}
                    @else
                    {{Form::checkbox('math', 1)}}
                    @endif
                </h5>
                    <h5>Animals: 
                    @if($user->animals)
                    {{Form::checkbox('animals', 1, true)}}
                    @else
                    {{Form::checkbox('animals', 1)}}
                    @endif
                </h5>
                    <h5>Books: 
                    @if($user->books)
                    {{Form::checkbox('books', 1, true)}}
                    @else
                    {{Form::checkbox('books', 1)}}
                    @endif
                </h5>
            </div>
            {{Form::submit('Save', ['class' => 'btn btn-primary'])}}
            {!! Form::close() !!}
        </div>
        <br/>
        <button class="btn btn-primary" onclick="toggleI()">Edit</button>
    @endif
@endsection