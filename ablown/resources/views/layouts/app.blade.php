<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'ABlown') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        .table > tbody > tr.mine:nth-child(2n) > td {
        background-color: #faf7e1;
        }
        .table > tbody > tr.mine:nth-child(2n+1) > td,
        .table > tbody > tr.mine:nth-child(2n):hover > td {
        background-color: #faf6d4;
        }
        .table > tbody > tr.mine:nth-child(2n+1):hover > td {
        background-color: #f7f1cb;
        }
    </style>
    <script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'>
    </script>
</head>
<body>
    <div id="app">
        @include('inc.navbar')
        <main class="container py-4">
            @include('inc.messages')
            @yield('content')
        </main>
    </div>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src='/ckeditor/ckeditor.js'></script>
    <script>
        CKEDITOR.replace('article-ckeditor');
    </script>
</body>
</html>
