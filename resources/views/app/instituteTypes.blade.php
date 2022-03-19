@extends('layouts.app')

@section('pagetitle', 'Institute Types')

@section('content')
<div>
    <div class="card mb-4">
        <div class="card-header">{{ __('Console') }}</div>
        <div class="card-body">
            <button type="button" class="btn btn-primary btn-icon-split" data-bs-toggle="modal" data-bs-target="#instituteTypeModal">
                <span class="icon text-white-50">
                    <i class="fa-solid fa-plus"></i>
                </span>
                <span class="text">Add Institute Type</span>
            </button>
        </div>
    </div>
    <div class="card">
        <div class="card-header">{{ __('Table') }}</div>
        <div class="card-body">
            <div id="institute-type-table"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="instituteTypeModal" tabindex="-1" aria-labelledby="instituteTypeModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="instituteTypeModalTitle">Add Institute Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="instituteTypeForm" action="{{route('instituteType.store')}}" method="post">
                    @method('post')
                    @csrf
                    <input id="id" name="id" type="hidden">
                    <div class="form-group row mb-4">
                        <label class="col-sm-2 col-form-label">Name: </label>
                        <div class="col-sm-10">
                            <input id="name" name="name" class="form-control" type="text" placeholder="ex: Organization" required>
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
    var table = new Tabulator("#institute-type-table", {
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
                title: "Name",
                field: "name",
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
                        $('#instituteTypeModalTitle').html('Edit Institute Type')
                        $('#instituteTypeForm').attr('action', "{{route('instituteType.update')}}");
                        $('input[name=name]').val(cell.getRow().getData().name)
                        $('input[name=id]').val(cell.getRow().getData().id)
                        var instituteTypeModal = new bootstrap.Modal(document.getElementById('instituteTypeModal'), {})
                        instituteTypeModal.toggle()
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
                        $('#confirmBoxForm').attr('action', "{{route('instituteType.delete')}}");
                        $('#confirmBoxForm').append(`<input id="instituteTypeId" name="id" type="hidden" value="${id}">`)
                        var confirmBox = new bootstrap.Modal(document.getElementById('confirmBox'), {})
                        confirmBox.toggle()
                    }
                }, ]
            },
        ]
    });
    table.on("tableBuilt", function() {
        table.setData("{{route('instituteType.data')}}");

        $('input[type=search]').attr("placeholder", "search..");
        $('input[type=search]').addClass('form-control');
        $('input[type=search]').css({
            'height': 'auto'
        });
    });
</script>
@endsection