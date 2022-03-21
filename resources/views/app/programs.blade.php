@extends('layouts.app')

@section('pagetitle', 'Programs')

@section('content')
<div>
    <div class="card mb-4">
        <div class="card-header">{{ __('Console') }}</div>
        <div class="card-body">
            <button type="button" class="btn btn-primary btn-icon-split" data-bs-toggle="modal" data-bs-target="#programModal">
                <span class="icon text-white-50">
                    <i class="fa-solid fa-plus"></i>
                </span>
                <span class="text">Add Program</span>
            </button>
        </div>
    </div>
    <div class="card">
        <div class="card-header">{{ __('Table') }}</div>
        <div class="card-body">
            <div id="program-table"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="programModal" tabindex="-1" aria-labelledby="programModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="programModalTitle">Add Program</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="programForm" action="{{route('program.store')}}" method="post">
                    @method('post')
                    @csrf
                    <input id="id" name="id" type="hidden">
                    <div class="form-group row mb-4">
                        <label class="col-sm-2 col-form-label">Name<b class="required">*</b>: </label>
                        <div class="col-sm-10">
                            <input id="name" name="name" class="form-control" type="text" placeholder="ex: Exchange Program" required>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-sm-2 col-form-label">Description: </label>
                        <div class="col-sm-10">
                            <textarea id="desc" name="desc" class="form-control" rows="8"></textarea>
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
    $('#programModal').on('hidden.bs.modal', function(e) {
        $('#programModalTitle').html('Add Program')
        $('#programForm').attr('action', "{{route('program.store')}}");
        $('input[name=id]').val("")
        $('input[name=name]').val("")
        $('input[name=desc], textarea').html("")
    })

    var deleteIcon = function(cell, formatterParams) {
        return '<i style="color: #C82333" class="fa-solid fa-trash"></i>';
    };
    var editIcon = function(cell, formatterParams) {
        return '<i style="color: #4E7AE4" class="far fa-edit"></i>';
    };
    var table = new Tabulator("#program-table", {
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
                title: "Description",
                field: "desc",
            },
            {
                title: "Action",
                columns: [{
                    title: "edit",
                    formatter: editIcon,
                    width: 70,
                    hozAlign: "center",
                    cellClick: function(e, cell) {
                        $('#programModalTitle').html('Edit Program')
                        $('#programForm').attr('action', "{{route('program.update')}}");
                        $('input[name=name]').val(cell.getRow().getData().name)
                        $('input[name=desc], textarea').html(cell.getRow().getData().desc)
                        var programModal = new bootstrap.Modal(document.getElementById('programModal'), {})
                        programModal.toggle()
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
                        $('#confirmBoxForm').attr('action', "{{route('program.delete')}}");
                        $('#confirmBoxForm').append(`<input id="programId" name="id" type="hidden" value="${id}">`)
                        var confirmBox = new bootstrap.Modal(document.getElementById('confirmBox'), {})
                        confirmBox.toggle()
                    }
                }, ]
            },
        ]
    });
    table.on("tableBuilt", function() {
        table.setData("{{route('program.data')}}");

        $('input[type=search]').attr("placeholder", "search..");
        $('input[type=search]').addClass('form-control');
        $('input[type=search]').css({
            'height': 'auto'
        });
    });
</script>
@endsection