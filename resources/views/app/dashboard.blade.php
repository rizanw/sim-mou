@extends('layouts.app')

@section('pagetitle', 'Dashboard')

@section('content')
<div>
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="fs-6 font-weight-bold text-primary mb-1">{!!$docNumberByType[0]['name']!!} ({!!$docNumberByType[0]['shortname']!!})</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{!!$docNumberByType[0]['number']!!}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fa-solid fa-file-lines fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success mb-1">{!!$docNumberByType[1]['name']!!} ({!!$docNumberByType[1]['shortname']!!})</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{!!$docNumberByType[1]['number']!!}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fa-solid fa-handshake fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info mb-1">{!!$docNumberByType[2]['name']!!} ({!!$docNumberByType[2]['shortname']!!})</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{!!$docNumberByType[2]['number']!!}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fa-solid fa-note-sticky fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning mb-1">{!!$docNumberByType[3]['name']!!} ({!!$docNumberByType[3]['shortname']!!})</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{!!$docNumberByType[3]['number']!!}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fa-solid fa-bullseye fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
@endsection

@section('script')
@yield('docByContinent')
@yield('partnerByContinent')
@yield('topPartnerByCountry')
@endsection