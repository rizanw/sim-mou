@extends('layouts.app')

@section('pagetitle', 'Documents')

@section('content')
<div>
    <div class="card shadow mb-4">
        <div class="card-header">{{ __('Console') }}</div>
        <div class="card-body">
            <a href="{{route('document.create')}}" class="btn btn-primary btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fa-solid fa-plus"></i>
                </span>
                <span class="text">Create Document</span>
            </a>
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{ __('Table') }}</h6>
        </div>
        <div class="card-body">
            <div id="document-table"></div>
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
                    title: "edit",
                    formatter: editIcon,
                    width: 70,
                    hozAlign: "center",
                    cellClick: function(e, cell) {
                        // todo: redirect to editor form
                    }
                }, {
                    title: "delete",
                    formatter: deleteIcon,
                    width: 70,
                    hozAlign: "center",
                    cellClick: function(e, cell) {
                        var name = cell.getRow().getData().name
                        var id = cell.getRow().getData().id
                        $('#confirmBoxBody').html(`Are you sure to delete "${name}"?`)
                        $('#confirmBoxForm').attr('action', "{{route('document.delete')}}");
                        $('#confirmBoxForm').append(`<input id="documentId" name="id" type="hidden" value="${id}">`)
                        var confirmBox = new bootstrap.Modal(document.getElementById('confirmBox'), {})
                        confirmBox.toggle()
                    }
                }, ]
            },
        ]
    });
    table.on("tableBuilt", function() {
        table.setData("{{route('document.data')}}");
        $('input[type=search]').attr("placeholder", "search..");
        $('input[type=search]').addClass('form-control');
        $('input[type=search]').css({
            'height': 'auto'
        });
    });
</script>
@endsection