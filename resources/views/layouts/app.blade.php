<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SIM-MoU') }}: @yield('pagetitle')</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-datepicker.css') }}" rel="stylesheet">
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
                    <div class="container">
                        @include('components.alert')
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="confirmBox" tabindex="-1" aria-labelledby="confirmBox" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmBoxTitle">Confirmation Box</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="confirmBoxBody" class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <form id="confirmBoxForm" method="POST">
                        @csrf
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                        <button type="submit" class="btn btn-primary">Yes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logoutModalLabel">Ready to Leave?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <a class="btn btn-primary" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
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
    @yield('script')
</body>

</html>