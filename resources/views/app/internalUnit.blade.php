@extends('layouts.app')
@section('pagetitle', 'Internal Units')

@section('content')
<nav class="nav nav-borders">
    <a class="nav-link" href="{{route('internal.institution')}}">Institution</a>
    <a class="nav-link active ms-0" href="{{route('internal.units')}}">Units</a>
</nav>
<hr class="mt-0 mb-4">
<div>
    <div class="card shadow mb-4">
        <div class="card-header">{{ __('Console') }}</div>
        <div class="card-body">
            <button type="button" class="btn btn-primary btn-icon-split" data-bs-toggle="modal" data-bs-target="#unitModal">
                <span class="icon text-white-50">
                    <i class="fa-solid fa-plus"></i>
                </span>
                <span class="text">Add Unit</span>
            </button>
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{ __('Table') }}</h6>
        </div>
        <div class="card-body">
            <div id="unit-table"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="unitModal" tabindex="-1" aria-labelledby="unitModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="unitModalTitle">Add Unit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="unitForm" action="{{route('internal.unit.store')}}" method="post">
                    @method('post')
                    @csrf
                    <input id="id" name="id" type="hidden">
                    <div class="form-group row mb-2">
                        <label class="col-sm-2 col-form-label">Name<b class="required">*</b>:</label>
                        <div class="col-sm-10">
                            <input id="name" name="name" class="form-control" type="text" placeholder="ex: Department Computer Science" required>
                        </div>
                    </div>
                    <div class="form-group row mb-2">
                        <label class="col-sm-2 col-form-label">Label<b class="required">*</b>:</label>
                        <div class="col-sm-10">
                            <input id="label" name="label" class="form-control" type="text" placeholder="ex: Department" required>
                            <div id="labelHelp" class="form-text">
                                Label is used to identify the kind of the unit, example: unit / faculty / department / directorate / etc.
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mb-2">
                        <label class="col-sm-2 col-form-label">Parent<b class="required">*</b>:</label>
                        <div class="col-sm-10">
                            <select id="parentSelect" name="parent" class="selectpicker form-control" data-live-search="true" required>
                                @foreach ($institutions as $institution)
                                @if (!isset($institution->parent_id))
                                <option data-subtext="{{$institution->institutionType->name}}" value="{{$institution->id}}">{{$institution->name}}</option>
                                @include('components.option-tree', ["entries"=>$institution->childInstitutions, "level"=>1])
                                @endif
                                @endforeach
                            </select>
                            <div id="instituteTypeHelp" class="form-text">
                                Please set the parent correctly based on its hierarchy.
                            </div>
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
    var table = new Tabulator("#unit-table", {
        placeholder: "No data",
        layout: "fitColumns",
        dataTree: true,
        dataTreeStartExpanded: true,
        columns: [{
                title: "Hierarchy",
                field: "label",
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
                        $('#unitModalTitle').html('Edit Unit')
                        $('#unitForm').attr('action', "{{route('internal.unit.update')}}");
                        $('input[name=id]').val(cell.getRow().getData().id)
                        $('input[name=name]').val(cell.getRow().getData().name)
                        $('input[name=label]').val(cell.getRow().getData().label)
                        $('input[name=website]').val(cell.getRow().getData().website)
                        $('input[name=telp]').val(cell.getRow().getData().telp)
                        $('input[name=email]').val(cell.getRow().getData().email)
                        $('#parentSelect').selectpicker('val', cell.getRow().getData().parent_id.toString())
                        $('#parentSelect').find('[value=' + cell.getRow().getData().id + ']').prop('disabled', true);
                        $('#parentSelect').selectpicker('refresh');
                        var unitModal = new bootstrap.Modal(document.getElementById('unitModal'), {})
                        unitModal.toggle()
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
                        $('#confirmBoxForm').attr('action', "{{route('internal.unit.delete')}}");
                        $('#confirmBoxForm').append(`<input id="unitId" name="id" type="hidden" value="${id}">`)
                        var confirmBox = new bootstrap.Modal(document.getElementById('confirmBox'), {})
                        confirmBox.toggle()
                    }
                }, ]
            },
        ]
    });
    table.on("tableBuilt", function() {
        table.setData("{{route('internal.unit.data')}}");
        $('input[type=search]').attr("placeholder", "search..");
        $('input[type=search]').addClass('form-control');
        $('input[type=search]').css({
            'height': 'auto'
        });
    });
</script>
@endsection