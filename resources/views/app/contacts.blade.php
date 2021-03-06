@extends('layouts.app')

@section('pagetitle', 'Contacts')

@section('content')
<div>
    <div class="card shadow mb-4">
        <div class="card-header">{{ __('Console') }}</div>
        <div class="card-body">
            <button type="button" class="btn btn-primary btn-icon-split" data-bs-toggle="modal" data-bs-target="#contactModal">
                <span class="icon text-white-50">
                    <i class="fa-solid fa-plus"></i>
                </span>
                <span class="text">Add Contact</span>
            </button>
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{ __('Table') }}</h6>
        </div>
        <div class="card-body">
            <div id="contact-table"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="contactModal" tabindex="-1" aria-labelledby="contactModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="contactModalTitle">Add Contact</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="contactForm" action="{{route('contact.store')}}" method="post">
                    @method('post')
                    @csrf
                    <input id="id" name="id" type="hidden">
                    <div class="form-group row mb-4">
                        <label class="col-sm-2 col-form-label">Full Name<b class="required">*</b>: </label>
                        <div class="col-sm-10">
                            <input id="fullname" name="fullname" class="form-control" type="text" placeholder="ex: Prof. Alpha Beta" required>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-sm-2 col-form-label">NickName: </label>
                        <div class="col-sm-10">
                            <input id="nickname" name="nickname" class="form-control" type="text" placeholder="ex: Alphabet">
                        </div>
                    </div>
                    <div class="form-group row mb-4" id="telps">
                        <label class="col-sm-2 col-form-label">Telp: </label>
                        <div class="col-sm-9">
                            <input id="telp" name="telp[]" class="form-control" type="tel" placeholder="ex: 628123456789">
                        </div>
                        <div class="col-sm-1 d-flex align-items-center">
                            <button type="button" class="btn btn-primary btn-sm telps">
                                <i class="fa-solid fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="form-group row mb-4" id="emails">
                        <label class="col-sm-2 col-form-label">Email: </label>
                        <div class="col-sm-9">
                            <input id="email" name="email[]" class="form-control" type="email" placeholder="ex: example@contact.person">
                        </div>
                        <div class="col-sm-1 d-flex align-items-center">
                            <button type="button" class="btn btn-primary btn-sm emails">
                                <i class="fa-solid fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-sm-2 col-form-label">Institutions<b class="required">*</b>: </label>
                        <div class="col-sm-10">
                            <select id="institutionSelect" name="institutions[]" class="selectpicker form-control" data-live-search="true" required multiple>
                                @foreach ($institutions as $institution)
                                @if (!isset($institution->parent_id))
                                <option data-subtext="{{$institution->institutionType->name}}" value="{{$institution->id}}">{{$institution->name}}</option>
                                @include('components.option-tree', ["entries"=>$institution->childInstitutions, "level"=>1])
                                @endif
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
    $('#contactModal').on('hidden.bs.modal', function(e) {
        $('#contactModalTitle').html('Add Contact')
        $('#contactForm').attr('action', "{{route('contact.store')}}");
        $('input[name=id]').val('')
        $('input[name=fullname]').val('')
        $('input[name=nickname]').val('')
        $('input[name="telp[]"]').val('')
        $('input[name="email[]"]').val('')
        $('#institutionSelect').selectpicker('deselectAll')
        $('div.telps').remove()
        $('div.emails').remove()
    })

    var telpComponent =
        `<div class="form-group row mb-4 telps">
            <label class="col-sm-2 col-form-label"></label>
            <div class="col-sm-9">
                <input id="telp" name="telp[]" class="form-control" type="tel" placeholder="ex: 628123456789">
            </div>
            <div class="col-sm-1 d-flex align-items-center">
                <button type="button" class="btn btn-danger btn-sm telp-del">
                    <i class="fa-solid fa-trash-can"></i>
                </button>
            </div>
        </div>`
    $(document).on('click', 'button.telps', function() {
        $(telpComponent).insertAfter('#telps')
    });
    $(document).on('click', 'button.telp-del', function() {
        var idx = $('button.telp-del').index(this)
        $('div.telps')[idx].remove()
    });
    var emailComponent =
        `<div class="form-group row mb-4 emails">
            <label class="col-sm-2 col-form-label"></label>
            <div class="col-sm-9">
                <input id="email" name="email[]" class="form-control" type="email" placeholder="ex: example@contact.person">
            </div>
            <div class="col-sm-1 d-flex align-items-center">
                <button type="button" class="btn btn-danger btn-sm email-del">
                    <i class="fa-solid fa-trash-can"></i>
                </button>
            </div>
        </div>`
    $(document).on('click', 'button.emails', function() {
        $(emailComponent).insertAfter('#emails')
    });
    $(document).on('click', 'button.email-del', function() {
        var idx = $('button.email-del').index(this)
        $('div.emails')[idx].remove()
    });

    var deleteIcon = function(cell, formatterParams) {
        return '<i style="color: #C82333" class="fa-solid fa-trash"></i>';
    };
    var editIcon = function(cell, formatterParams) {
        return '<i style="color: #4E7AE4" class="far fa-edit"></i>';
    };
    var table = new Tabulator("#contact-table", {
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
                title: "Full Name (NickName)",
                field: "name",
                headerFilter: true
            },
            {
                title: "Institution",
                field: "institution.name",
                headerFilter: true
            },
            {
                title: "Institution Units",
                field: "units",
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
                        $('#contactModalTitle').html('Edit Contact')
                        $('#contactForm').attr('action', "{{route('contact.update')}}");
                        $('input[name=id]').val(cell.getRow().getData().id)
                        $('input[name=fullname]').val(cell.getRow().getData().fullname)
                        $('input[name=nickname]').val(cell.getRow().getData().nickname)
                        if (cell.getRow().getData().institute) {
                            $("#instituteForm").attr('hidden', false)
                            $('#instituteSelect').selectpicker("val", cell.getRow().getData().institute.id.toString())
                        }
                        for (let index = 0; index < cell.getRow().getData().telp.length - 1; index++) {
                            $(telpComponent).insertAfter('#telps')
                            $('input[name="telp[]"]').eq(index).val(cell.getRow().getData().telp[index]);
                        }
                        $('input[name="telp[]"]:last').val(cell.getRow().getData().telp[cell.getRow().getData().telp.length - 1]);
                        for (let index = 0; index < cell.getRow().getData().email.length - 1; index++) {
                            $(emailComponent).insertAfter('#emails')
                            $('input[name="email[]"]').eq(index).val(cell.getRow().getData().email[index]);
                        }
                        $('input[name="email[]"]:last').val(cell.getRow().getData().email[cell.getRow().getData().email.length - 1]);
                        $("#institutionSelect").selectpicker("val", cell.getRow().getData().institutions.map(String))

                        var contactModal = new bootstrap.Modal(document.getElementById('contactModal'), {})
                        contactModal.toggle()
                    }
                }, {
                    title: "delete",
                    formatter: deleteIcon,
                    width: 70,
                    hozAlign: "center",
                    cellClick: function(e, cell) {
                        var name = cell.getRow().getData().name
                        var id = cell.getRow().getData().id
                        var institutions = cell.getRow().getData().institutions
                        $('#confirmBoxBody').html(`Are you sure to delete "${name}"?`)
                        $('#confirmBoxForm').attr('action', "{{route('contact.delete')}}");
                        $('#confirmBoxForm').append(`<input id="contactId" name="id" type="hidden" value="${id}">`)
                        institutions.forEach(element => {
                            $('#confirmBoxForm').append(`<input name="institutions[]" type="hidden" value="${element}">`)
                        });
                        var confirmBox = new bootstrap.Modal(document.getElementById('confirmBox'), {})
                        confirmBox.toggle()
                    }
                }, ]
            },
        ]
    });
    table.on("tableBuilt", function() {
        table.setData("{{route('contact.data')}}");

        $('input[type=search]').attr("placeholder", "search..");
        $('input[type=search]').addClass('form-control');
        $('input[type=search]').css({
            'height': 'auto'
        });
    });
</script>
@endsection