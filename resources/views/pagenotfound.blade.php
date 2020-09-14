<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>window.Laravel = { csrfToken: '{{ csrf_token() }}'}</script>
    <title>PageNotFound</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">


</head>
<body>
<div id="app" >

    @if(session()->has('msg'))
        <div class="alert alert-danger text-center">
        <h1>{!! session()->get('msg') !!}</h1>
        </div>
    @endif
</div>

<script src=" {{asset('js/app.js') }}"></script>
</body>
</html>
