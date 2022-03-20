@extends('layouts.app')

@section('pagetitle', 'Institutions')

@section('content')
<div>
    <div class="card mb-4">
        <div class="card-header">{{ __('Console') }}</div>
        <div class="card-body">
            <button type="button" class="btn btn-primary btn-icon-split" data-bs-toggle="modal" data-bs-target="#institutionModal">
                <span class="icon text-white-50">
                    <i class="fa-solid fa-plus"></i>
                </span>
                <span class="text">Add Institution</span>
            </button>
        </div>
    </div>
    <div class="card">
        <div class="card-header">{{ __('Table') }}</div>
        <div class="card-body">
            <div id="institution-table"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="institutionModal" tabindex="-1" aria-labelledby="institutionModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="institutionModalTitle">Add Institution</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="institutionForm" action="{{route('institution.store')}}" method="post">
                    @method('post')
                    @csrf
                    <input id="id" name="id" type="hidden">

                    <div class="form-group row mb-4">
                        <label class="col-sm-2 col-form-label"><b>General:</b></label>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-sm-2 col-form-label">Type<b class="required">*</b>:</label>
                        <div class="col-sm-10">
                            <select id="typeSelect" name="institution_type" class="selectpicker form-control" data-live-search="true" required>
                                <option disabled selected>--- Select a Institution Type ---</option>
                                @foreach ($institutionTypes as $institutionType)
                                <option value="{{$institutionType->id}}">{{$institutionType->name}}</option>
                                @endforeach
                            </select>
                            <div id="instituteTypeHelp" class="form-text">create more institution type?
                                <a href="{{route('institutionTypes')}}" class="link-secondary">create here</a>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-sm-2 col-form-label">Name<b class="required">*</b>: </label>
                        <div class="col-sm-10">
                            <input id="name" name="name" class="form-control" type="text" placeholder="ex: Institut Teknologi Sepuluh Nopember" required>
                        </div>
                    </div>
                    <hr />
                    <div class="form-group row mb-4">
                        <label class="col-sm-2 col-form-label"><b>Contact:</b></label>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-sm-2 col-form-label">Website: </label>
                        <div class="col-sm-10">
                            <input id="website" name="website" class="form-control" type="text" placeholder="ex: example.com">
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-sm-2 col-form-label">Telp: </label>
                        <div class="col-sm-10">
                            <input id="telp" name="telp" class="form-control" type="tel" placeholder="ex: 628123456789">
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-sm-2 col-form-label">Email: </label>
                        <div class="col-sm-10">
                            <input id="email" name="email" class="form-control" type="email" placeholder="ex: example@insitute.com">
                        </div>
                    </div>
                    <hr />
                    <div class="form-group row mb-4">
                        <label class="col-sm-2 col-form-label"><b>Location:</b></label>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-sm-2 col-form-label">Continent: </label>
                        <div class="col-sm-10">
                            <select id="continentSelect" name="continent_id" class="selectpicker form-control" data-live-search="true" disabled>
                                <option disabled selected>--- automatically select ---</option>
                                @foreach ($continents as $continent)
                                <option value="{{$continent->id}}">{{$continent->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-sm-2 col-form-label">Country<b class="required">*</b>: </label>
                        <div class="col-sm-10">
                            <select id="countrySelect" name="country_id" class="selectpicker form-control" data-live-search="true" required>
                                <option disabled selected>--- Select a country ---</option>
                                @foreach ($countries as $country)
                                <option data-continent="{{$country->continent_id}}" data-subtext="{{$country->continent->name}}" value="{{$country->id}}">{{$country->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-sm-2 col-form-label">Address: </label>
                        <div class="col-sm-10">
                            <input id="address" name="address" class="form-control" type="text" placeholder="ex: Jl. example street, city, province (1234)">
                        </div>
                    </div>

                    <div>
                        <div style="float: right;">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
    $('#countrySelect').on('change', function(e) {
        $("#continentSelect").selectpicker("val", this.options[this.selectedIndex].dataset.continent)
    });

    var deleteIcon = function(cell, formatterParams) {
        return '<i style="color: #C82333" class="fa-solid fa-trash"></i>';
    };
    var editIcon = function(cell, formatterParams) {
        return '<i style="color: #4E7AE4" class="far fa-edit"></i>';
    };
    var showIcon = function(cell, formatterParams) {
        return '<i style="color: #4E7AE4" class="fa-solid fa-eye"></i>';
    };
    var table = new Tabulator("#institution-table", {
        placeholder: "No data",
        layout: "fitColumns",
        pagination: "local",
        paginationSize: 15,
        columns: [{
                title: "No",
                formatter: "rownum",
                width: 60
            },
            {
                field: "id",
                visible: false,
            },
            {
                title: "Type",
                field: "type.name",
                headerFilter: true
            },
            {
                title: "Name",
                field: "name",
                headerFilter: true
            },
            {
                title: "Continent",
                field: "country.continent.name",
                headerFilter: true
            },
            {
                title: "Country",
                field: "country.name",
                headerFilter: true
            },
            {
                title: "Action",
                columns: [{
                    title: "show",
                    formatter: showIcon,
                    width: 70,
                    hozAlign: "center",
                    cellClick: function(e, cell) {
                        var url = '{{ route("units", ":id") }}';
                        url = url.replace(':id', cell.getRow().getData().id.toString());
                        location.href = url
                    }
                }, {
                    title: "edit",
                    formatter: editIcon,
                    width: 70,
                    hozAlign: "center",
                    cellClick: function(e, cell) {
                        $('#institutionModalTitle').html('Edit Institution')
                        $('#institutionForm').attr('action', "{{route('institution.update')}}");
                        $('input[name=name]').val(cell.getRow().getData().name)
                        $('input[name=id]').val(cell.getRow().getData().id)
                        $('input[name=website]').val(cell.getRow().getData().website)
                        $('input[name=telp]').val(cell.getRow().getData().telp)
                        $('input[name=email]').val(cell.getRow().getData().email)
                        $('input[name=address]').val(cell.getRow().getData().address)
                        $("#typeSelect").selectpicker("val", cell.getRow().getData().type.id.toString())
                        $("#continentSelect").selectpicker("val", cell.getRow().getData().country.continent.id)
                        $("#countrySelect").selectpicker("val", cell.getRow().getData().country.id)
                        var institutionModal = new bootstrap.Modal(document.getElementById('institutionModal'), {})
                        institutionModal.toggle()
                    }
                }, {
                    title: "delete",
                    formatter: deleteIcon,
                    width: 70,
                    hozAlign: "center",
                    cellClick: function(e, cell) {
                        var name = cell.getRow().getData().name
                        var id = cell.getRow().getData().id
                        $('#confirmBoxBody').html(`Are you sure to delete "(${id})${name}"?`)
                        $('#confirmBoxForm').attr('action', "{{route('institution.delete')}}");
                        $('#confirmBoxForm').append(`<input id="institutionId" name="id" type="hidden" value="${id}">`)
                        var confirmBox = new bootstrap.Modal(document.getElementById('confirmBox'), {})
                        confirmBox.toggle()
                    }
                }, ]
            },
        ]
    });
    table.on("tableBuilt", function() {
        table.setData("{{route('institution.data')}}");

        $('input[type=search]').attr("placeholder", "search..");
        $('input[type=search]').addClass('form-control');
        $('input[type=search]').css({
            'height': 'auto'
        });
    });
</script>
@endsection