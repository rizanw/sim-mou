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
    <div class="row">
        <div class="col">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Agreements by Continent</h6>
                </div>
                <div class="card-body">
                    @include('charts.docByContinent')
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Partners by Continent</h6>
                </div>
                <div class="card-body">
                    @include('charts.partnerByContinent')
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Top Countries by Number of Partners</h6>
                </div>
                <div class="card-body">
                    @include('charts.topPartnerByCountry')
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@section('script')
@yield('docByContinent')
@yield('partnerByContinent')
@yield('topPartnerByCountry')
@endsection