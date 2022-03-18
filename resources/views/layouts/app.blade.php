<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SIM-MoU') }} : @yield('pagetitle')</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        .col-auto {
            margin-bottom: 4px;
        }

        .checkbox-list-box {
            border: 1px solid #ccc;
            width: auto;
            height: 300px;
            overflow-y: scroll;
            padding: 10px;
        }

        .btn-search {
            color: #6e707e;
            background-color: #fff;
            border-color: #d1d3e2;
        }

        .btn-search:hover {
            color: #6e707e;
            background-color: #fff;
            border-color: #d1d3e2;
        }

        .btn-search:active {
            color: #6e707e;
            background-color: #fff;
            border-color: #d1d3e2;
        }

        .no-js #loader {
            display: none;
        }

        .js #loader {
            display: block;
            position: absolute;
            left: 100px;
            top: 0;
        }

        .preload-background {
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: rgba(250, 250, 250, 0.7);
        }

        .preload-icon {
            position: absolute;
            left: 50%;
            top: 50%;
        }
    </style>
</head>

<body id="page-top">
    <div class="preload-background">
        <div class="spinner-border text-danger preload-icon" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>

    <div id="wrapper">
        @include('layouts.sidebar')
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                @include('layouts.topbar')
                <div class="container-fluid">
                    <h1 class="h3 mb-4 text-gray-800">@yield('pagetitle')</h1>
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
    <script type="text/javascript">
        $(window).on('load', function() {
            // Animate loader off screen
            $(".preload-background").fadeOut("slow");
        });
    </script>
</body>

</html>