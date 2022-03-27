@extends('layouts.app')

@section('pagetitle', 'Countries')

@section('content')
<div>
    <div class="card mb-4">
        <div class="card-header">{{ __('Console') }}</div>

        <div class="card-body">
            <button type="button" class="btn btn-primary btn-icon-split" data-bs-toggle="modal" data-bs-target="#countryModal">
                <span class="icon text-white-50">
                    <i class="fa-solid fa-plus"></i>
                </span>
                <span class="text">Add Country</span>
            </button>
        </div>
    </div>

    <div class="card">
        <div class="card-header">{{ __('Table') }}</div>

        <div class="card-body">
            <div id="country-table"></div>
            <div>
                <a class="small underline" href="https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2#Officially_assigned_code_elements" target="_blank">
                    What is ISO (3166-1) Country alpha-2 code? read here!
                </a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="countryModal" tabindex="-1" aria-labelledby="countryModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="countryModalTitle">Add Country</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="countryForm" action="{{route('country.store')}}" method="post">
                    @method('post')
                    @csrf
                    <input id="id" name="id" type="hidden">
                    <div class="form-group row mb-2">
                        <label class="col-sm-2 col-form-label">Code<b class="required">*</b>: </label>
                        <div class="col-sm-10">
                            <input id="code" name="code" class="form-control" type="text" placeholder="ex: ID" required>
                        </div>
                    </div>
                    <div class="form-group row mb-2">
                        <label class="col-sm-2 col-form-label">Name<b class="required">*</b>: </label>
                        <div class="col-sm-10">
                            <input id="name" name="name" class="form-control" type="text" placeholder="ex: Indonesia" required>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-sm-2 col-form-label">Continent<b class="required">*</b>: </label>
                        <div class="col-sm-10">
                            <select name="continent_id" class="selectpicker form-control" data-live-search="true" required>
                                <option disabled selected>--- Select a continent ---</option>
                                @foreach ($continents as $continent)
                                <option value="{{$continent->id}}">{{$continent->name}}</option>
                                @endforeach
                            </select>
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
    var deleteIcon = function(cell, formatterParams) {
        return '<i style="color: #C82333" class="fa-solid fa-trash"></i>';
    };
    var editIcon = function(cell, formatterParams) {
        return '<i style="color: #4E7AE4" class="far fa-edit"></i>';
    };
    var flag = function(cell, formatterParams) {
        return `<span class="fi fi-${cell.getRow().getData().id.toLowerCase()}"></span>`;
    };
    var table = new Tabulator("#country-table", {
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
                title: "Code (ISO 3166-1 alpha-2)",
                field: "id",
                hozAlign: "center",
                headerFilter: true
            },
            {
                title: "Flag",
                formatter: flag,
                hozAlign: "center",
                width: 60
            },
            {
                title: "Name",
                field: "name",
                headerFilter: true
            },
            {
                title: "Continent code",
                field: "continent.id",
                hozAlign: "center",
                headerFilter: true
            },
            {
                title: "Continent Name",
                field: "continent.name",
                headerFilter: true
            },
            {
                title: "Action",
                columns: [{
                    title: "edit",
                    formatter: editIcon,
                    width: 70,
                    hozAlign: "center",
                    cellClick: function(e, cell) {
                        $('#countryModalTitle').html('Edit Country')
                        $('#countryForm').attr('action', "{{route('country.update')}}");
                        $('input[name=name]').val(cell.getRow().getData().name)
                        $('input[name=id]').val(cell.getRow().getData().id)
                        $('input[name=code]').val(cell.getRow().getData().id)
                        $('input[name=code]').attr('disabled', "true");
                        $('.selectpicker').selectpicker('val', cell.getRow().getData().continent.id);
                        var countryModal = new bootstrap.Modal(document.getElementById('countryModal'), {})
                        countryModal.toggle()
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
                        $('#confirmBoxForm').attr('action', "{{route('country.delete')}}");
                        $('#confirmBoxForm').append(`<input id="countryid" name="id" type="hidden" value="${id}">`)
                        var confirmBox = new bootstrap.Modal(document.getElementById('confirmBox'), {})
                        confirmBox.toggle()
                    }
                }, ]
            },
        ]
    });
    table.on("tableBuilt", function() {
        table.setData("{{route('country.data')}}");

        $('input[type=search]').attr("placeholder", "search..");
        $('input[type=search]').addClass('form-control');
        $('input[type=search]').css({
            'height': 'auto'
        });
    });
</script>
@endsection