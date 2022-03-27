@extends('layouts.error')

@section('pagetitle', '404 - Not Found')

@section('content')
<div class="container-fluid" style="display: flex; justify-content: center; align-items: center;">
    <div class="text-center">
        <div class="error mx-auto" data-text="404">404</div>
        <p class="lead text-gray-800 mb-5">Page Not Found</p>
        <p class="text-gray-500 mb-0">It looks like you found a glitch in the matrix...</p>
        <a href="{{route('404.redirection')}}">← Back to Home</a>
    </div>
</div>
@endsection