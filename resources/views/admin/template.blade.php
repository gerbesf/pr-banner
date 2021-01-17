<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ env('APP_NAME') }}</title>

    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <style>
        body {
            font-family: 'Nunito';
        }
    </style>
</head>
<body>
<div class="container">

    <div class="pt-4">
        <h3>PR-Banner - {{ env('APP_NAME') }}</h3>
        <p class="lead">Simple Project Reality Banner Generator</p>
    </div>

    @yield('main')
</div>
</body>
</html>
