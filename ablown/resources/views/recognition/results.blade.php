@extends('layouts.app')
@section('content')
    <small>The below information is for reference only, please do not trust it completely.</small><br/><br/>
    <img class="img-fluid" src="/storage/images/face/{{$filename}}" alt="Image"/>
        <div class="row">
        @if(count($faces) > 0)
            @foreach($faces as $face)
                <div class="card col mx-2 my-2">
                    <div class="card-body">
                        <h5>Basic Information</h5>
                        <div class="container">
                            <p class="card-text">Gender: {{$face->faceAttributes->gender}}</p>
                            <p class="card-text">Age: {{$face->faceAttributes->age}}</p>
                        </div>
                        <br/>
                        <h5>Emotion</h5>
                        <div class="container">
                            <p class="card-text">Anger: {{round($face->faceAttributes->emotion->anger * 100)}}%</p>
                            <p class="card-text">Contempt: {{round($face->faceAttributes->emotion->contempt * 100)}}%</p>
                            <p class="card-text">Disgust: {{round($face->faceAttributes->emotion->disgust * 100)}}%</p>
                            <p class="card-text">Fear: {{round($face->faceAttributes->emotion->fear * 100)}}%</p>
                            <p class="card-text">Happiness: {{round($face->faceAttributes->emotion->happiness * 100)}}%</p>
                            <p class="card-text">Neutral: {{round($face->faceAttributes->emotion->neutral * 100)}}%</p>
                            <p class="card-text">Sadness: {{round($face->faceAttributes->emotion->sadness * 100)}}%</p>
                            <p class="card-text">Surprise: {{round($face->faceAttributes->emotion->surprise * 100)}}%</p>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <p>No faces found</p>
        @endif
    </div>
@endsection