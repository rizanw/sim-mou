@extends('layouts.app')
@section('pagetitle', 'Internal Institution')

@section('content')
<nav class="nav nav-borders">
    <a class="nav-link active ms-0" href="{{route('internal.institution')}}">Institution</a>
    <a class="nav-link" href="account-billing.html">Units</a>
</nav>
<hr class="mt-0 mb-4">
<div>
    <div class="card mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Institution</h6>
            <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink" style="position: absolute; transform: translate3d(-158px, 18px, 0px); top: 0px; left: 0px; will-change: transform;" x-placement="bottom-end">
                    <a class="dropdown-item" href="{{route('internal.institution.edit')}}">edit</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form action="{{route('internal.institution.update')}}" method="post">
                @csrf
                <div class="row align-items-start">
                    <div class="form-group row mb-4">
                        <label class="col-sm-2 col-form-label">Name<b class="required">*</b>: </label>
                        <div class="col-sm-10">
                            <input id="name" name="name" value="{{$institution->name}}" class="form-control" type="text" placeholder="ex: Our Best Institution" {{isset($isEdit)?'':'disabled'}} required>
                        </div>
                    </div>
                </div>
                <hr />
                <div class="row align-items-start">
                    <div class="col-7">
                        <h6 class="m-0 font-weight-bold">Location</h6>
                        <hr />
                        <div class="form-group row mb-2">
                            <label class="col-sm-4 col-form-label"><i class="fa-solid fa-globe"></i> Continent / Country<b class="required">*</b>: </label>
                            <div class="col-sm-8">
                                @if (isset($isEdit))
                                <select id="countrySelect" name="country" class="selectpicker form-control" data-live-search="true" required>
                                    <option value="0" disabled selected>--- Select a country ---</option>
                                    @foreach ($countries as $country)
                                    @if ($country->id == $institution->country->id)
                                    <option data-continent="{{$country->continent_id}}" data-subtext="{{$country->continent->name}}" value="{{$country->id}}" selected>{{$country->name}}</option>
                                    @else
                                    <option data-continent="{{$country->continent_id}}" data-subtext="{{$country->continent->name}}" value="{{$country->id}}">{{$country->name}}</option>
                                    @endif
                                    @endforeach
                                </select>
                                @else
                                <p class="m-0 mt-2">{{$institution->country->continent->name}} / <b>{{$institution->country->name}}</b></p>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row mb-2">
                            <label class="col-sm-4 col-form-label"><i class="fa-solid fa-location-dot"></i> Address: </label>
                            <div class="col-sm-8">
                                @if (isset($isEdit))
                                <input id="address" name="address" value="{{$institution->address}}" class="form-control" type="text" placeholder="ex: Jl Street, City, Province PostalCode" required>
                                @else
                                <p class="m-0 mt-2">{{$institution->address}}</b></p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-5">
                        <h6 class="m-0 font-weight-bold">Contact</h6>
                        <hr />
                        <div class="form-group row mb-2">
                            <label class="col-sm-4 col-form-label"><i class="fa-brands fa-internet-explorer"></i> Website: </label>
                            <div class="col-sm-8">
                                @if (isset($isEdit))
                                <input id="website" name="website" value="{{$institution->website}}" class="form-control" type="text" placeholder="ex: institution.com" required>
                                @else
                                <p class="m-0 mt-2"><a href="http://{{$institution->website}}" target="_blank" class="link-secondary">{{$institution->website}}</a></b></p>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row mb-2">
                            <label class="col-sm-4 col-form-label"><i class="fa-solid fa-phone"></i> Telp: </label>
                            <div class="col-sm-8">
                                @if (isset($isEdit))
                                <input id="telp" name="telp" value="{{$institution->telp}}" class="form-control" type="telp" placeholder="ex: 628123456789">
                                @else
                                <p class="m-0 mt-2"><a href="telp://{{$institution->telp}}" target="_blank" class="link-secondary">{{$institution->telp}}</a></b></p>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row mb-2">
                            <label class="col-sm-4 col-form-label"><i class="fa-solid fa-at"></i> Email: </label>
                            <div class="col-sm-8">
                                @if (isset($isEdit))
                                <input id="email" name="email" value="{{$institution->email}}" class="form-control" type="text" placeholder="ex: info@institution.com">
                                @else
                                <p class="m-0 mt-2"><a href="mailto://{{$institution->email}}" target="_blank" class="link-secondary">{{$institution->email}}</a></b></p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @if (isset($isEdit))
                <hr />
                <div style="float: right;">
                    <a href="{{route('internal.institution')}}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
                @endif
            </form>
        </div>
    </div>
    @endsection