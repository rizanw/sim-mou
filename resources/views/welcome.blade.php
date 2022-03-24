@extends('layouts.auth')

@section('pagetitle', 'Contacts')

@section('content')
@if (Route::has('login'))
<div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
    @auth
    <a href="{{ url('/app') }}" class="text-sm text-white underline">Home</a>
    @else
    <a href="{{ route('login') }}" class="text-sm text-white underline">Log in</a>

    @if (Route::has('register'))
    <a href="{{ route('register') }}" class="ml-4 text-sm text-white underline">Register</a>
    @endif
    @endauth
</div>
@endif
@endsection