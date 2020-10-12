<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>window.Laravel = { csrfToken: '{{ csrf_token() }}'}</script>
    <title>AutoServicce24</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">


</head>
<body>
<div id="app">

    @auth
        <index :user="{{Auth::user()}}" :permission="{{Auth::user()->role->permission}}"></index>
    @endauth

    @guest
        <welcome></welcome>
    @endguest
</div>

<script src=" {{asset('js/app.js') }}"></script>
</body>
</html>
