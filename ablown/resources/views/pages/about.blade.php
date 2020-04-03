@extends('layouts.app')

@section('content')
    <h1>{{$title}}</h1>
    <h3>Creators:</h3>
    @if(count($creators) > 0)
    <ul class='list-group'>
        @foreach($creators as $creator)
            <li class='list-group-item'>{{$creator}}</li>
        @endforeach
    <ul>
    @endif
@endsection