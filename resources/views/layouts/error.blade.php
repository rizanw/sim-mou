<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'SIM-MoU') }}: @yield('pagetitle')</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        a {
            color: #4e73df;
            text-decoration: none;
            background-color: transparent;
        }
    </style>
</head>

<body id="page-top">
    <div id="wrapper" style="height: 100vh;">
    <div id="content-wrapper" class="d-flex">@yield('content')</div>
    </div>
    @yield('script')
</body>