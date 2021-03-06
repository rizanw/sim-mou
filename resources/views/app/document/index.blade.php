@extends('layouts.app')

@section('pagetitle', 'Documents')

@section('content')
<div>
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2" onclick="filterStatus('Active')" style="cursor: pointer;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Active</div>
                            <div id="active" class="h5 mb-0 font-weight-bold text-gray-800">0</div>
                        </div>
                        <div class="col-auto">
                            <i class="fa-solid fa-file-circle-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2" onclick="filterStatus('In Renewal')" style="cursor: pointer;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">In Renewal</div>
                            <div id="inrenewal" class="h5 mb-0 font-weight-bold text-gray-800">0</div>
                        </div>
                        <div class="col-auto">
                            <i class="fa-solid fa-arrow-rotate-left fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2" onclick="filterStatus('Expired')" style="cursor: pointer;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Expired</div>
                            <div id="expired" class="h5 mb-0 font-weight-bold text-gray-800">0</div>
                        </div>
                        <div class="col-auto">
                            <i class="fa-solid fa-file-circle-exclamation fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2" onclick="filterStatus('Inactive')" style="cursor: pointer;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Inactive</div>
                            <div id="inactive" class="h5 mb-0 font-weight-bold text-gray-800">0</div>
                        </div>
                        <div class="col-auto">
                            <i class="fa-solid fa-file-circle-xmark fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header">{{ __('Console') }}</div>
        <div class="card-body">
            <a href="{{route('document.create')}}" class="btn btn-primary btn-icon-split m-2">
                <span class="icon text-white-50">
                    <i class="fa-solid fa-plus"></i>
                </span>
                <span class="text">Create Document</span>
            </a>
            <button onclick="refreshTable()" class="btn btn-success btn-icon-split m-2">
                <span class="icon text-white-50">
                    <i class="fa-solid fa-arrow-rotate-left"></i>
                </span>
                <span class="text">Reset Table</span>
            </button>
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">{{ __('Table') }}</h6>
            <div style="cursor:pointer;" onclick="refreshTable()" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Refresh Table">
                <i class="fa-solid fa-arrow-rotate-left text-success"></i>
            </div>
        </div>
        <div class="card-body">
            <div class="accordion accordion-flush" id="accordionFlushExample">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingOne">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                            Additional Filter (click here)
                        </button>
                    </h2>
                    <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            <div class="d-flex flex-row bd-highlight mb-3">
                                <div class="p-2">
                                    <label for="inputFilterCountry" class="form-label">Country</label>
                                    <select id="inputFilterCountry" class="form-select">
                                        <option disabled selected>Select a country</option>
                                        @foreach($countries as $country)
                                        <option value="{{$country}}">{{$country}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="p-2">
                                    <label for="inputFilterContinent" class="form-label">Continent</label>
                                    <select id="inputFilterContinent" class="form-select">
                                        <option disabled selected>Select a continent</option>
                                        @foreach($continents as $continent)
                                        <option value="{{$continent}}">{{$continent}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="document-table"></div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
    var deleteIcon = function(cell, formatterParams) {
        return '<i class="fa-solid fa-trash text-danger"></i>';
    };
    var editIcon = function(cell, formatterParams) {
        return '<i class="far fa-edit text-primary"></i>';
    };
    var showIcon = function(cell, formatterParams) {
        return '<i class="fa-solid fa-eye text-info"></i>';
    };
    var table = new Tabulator("#document-table", {
        placeholder: "No data",
        layout: "fitColumns",
        pagination: "local",
        paginationSize: 15,
        columns: [{
                field: "id",
                visible: false,
            },
            {
                title: "Number",
                field: "number",
                headerFilter: true
            },
            {
                title: "Type",
                field: "type.shortname",
                headerFilter: true,
                width: 75
            },
            {
                title: "Title",
                field: "title",
                headerFilter: true
            },
            {
                title: "Partner(s)",
                field: "partners",
                headerFilter: true
            },
            {
                title: "Status",
                field: "status",
                headerFilter: true,
                width: 95
            },
            {
                title: "Validity Period",
                columns: [{
                    title: "Start Date",
                    field: "startDate",
                    headerFilter: true,
                    width: 110
                }, {
                    title: "End Date",
                    field: "endDate",
                    headerFilter: true,
                    width: 110
                }]
            },
            {
                title: "Action",
                columns: [{
                    title: "show",
                    formatter: showIcon,
                    width: 70,
                    hozAlign: "center",
                    cellClick: function(e, cell) {
                        var url = '{{ route("document.detail", ":id") }}';
                        url = url.replace(':id', cell.getRow().getData().id.toString());
                        location.href = url
                    }
                }, {
                    title: "edit",
                    formatter: editIcon,
                    width: 70,
                    hozAlign: "center",
                    cellClick: function(e, cell) {
                        var url = '{{ route("document.edit", ":id") }}';
                        url = url.replace(':id', cell.getRow().getData().id.toString());
                        location.href = url;
                    }
                }, {
                    title: "delete",
                    formatter: deleteIcon,
                    width: 70,
                    hozAlign: "center",
                    cellClick: function(e, cell) {
                        var title = cell.getRow().getData().title
                        var number = cell.getRow().getData().number
                        var id = cell.getRow().getData().id
                        $('#confirmBoxBody').html(`Are you sure to delete "(${number})${title}"?`)
                        $('#confirmBoxForm').attr('action', "{{route('document.delete')}}");
                        $('#confirmBoxForm').append(`<input id="documentId" name="id" type="hidden" value="${id}">`)
                        var confirmBox = new bootstrap.Modal(document.getElementById('confirmBox'), {})
                        confirmBox.toggle()
                    }
                }, ]
            },
        ],
        footerElement: "<span id='row-count'>total data: 0</span>",
    });
    table.on("tableBuilt", function() {
        table.setData("{{route('document.data')}}");
        headerStyle();
    });
    table.on("dataLoaded", function(data) {
        counter = {}
        if (data.length > 0) {
            data.forEach(function(obj) {
                var key = JSON.stringify(obj.status.toLowerCase())
                counter[key] = (counter[key] || 0) + 1
            })
        }
        $('#active').html(counter['"active"'])
        $('#expired').html(counter['"expired"'])
        $('#inactive').html(counter['"inactive"'])
        $('#inrenewal').html(counter['"in renewal"'])
    });
    table.on("dataFiltered", function(filters, rows) {
        $("#row-count").html("total data: " + rows.length)
    });
    var headerStyle = () => {
        $('input[type=search]').attr("placeholder", "search..");
        $('input[type=search]').addClass('form-control');
        $('input[type=search]').css({
            'height': 'auto'
        });
    }
    var filterStatus = (status) => {
        table.setFilter("status", "=", status);
    }
    var refreshTable = () => {
        $("select").prop('selectedIndex', 0);
        table.clearFilter();
        table.clearHeaderFilter();
        headerStyle();
    }
    $('select#inputFilterCountry').on('input', function(e) {
        table.setFilter("country", "like", $("select#inputFilterCountry").val());
        $("select#inputFilterContinent").prop('selectedIndex', 0);
    });
    $('select#inputFilterContinent').on('input', function(e) {
        table.setFilter("continent", "like", $("select#inputFilterContinent").val());
        $("select#inputFilterCountry").prop('selectedIndex', 0);
    });
</script>
@endsection