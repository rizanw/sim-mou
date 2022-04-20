@extends('layouts.app')

@section('pagetitle', $pageTitle)

@section('content')
<form id="documentForm" action="{{$url}}" method="post" enctype="multipart/form-data">
    @if ($viewType == 'detail')
    <div class="card shadow mb-4">
        <div class="card-header">{{ __('Console') }}</div>
        <div class="card-body">
            <div>
                <a href="{{route('document.edit', $id)}}" class="btn btn-primary btn-icon-split m-2">
                    <span class="icon text-white-50">
                        <i class="far fa-edit"></i>
                    </span>
                    <span class="text">Edit Document</span>
                </a>
                @if (isset($isRenewable) && $isRenewable)
                <a href="{{route('document.create', ['renew' => $id])}}" class="btn btn-success btn-icon-split m-2">
                    <span class="icon text-white-50">
                        <i class="fa-solid fa-arrow-rotate-left"></i>
                    </span>
                    <span class="text">Renew Document</span>
                </a>
                @endif
            </div>
        </div>
    </div>
    @endif
    @method('post')
    @csrf
    <input id="id" name="id" value="{{isset($document)?$document->id:''}}" type="hidden">
    <input id="renew" name="renew" value="{{isset($oldDocument)?$oldDocument->id:''}}" type="hidden">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{ __('Validity Period') }}</h6>
        </div>
        <div class="card-body">
            <div class="form-group row mb-4">
                <label class="col-sm-2 col-form-label">Status<b class="required">*</b>:</label>
                <div class="col-sm-10">
                    <select id="status" name="status" class="selectpicker form-control" data-live-search="true" required {{isset($isReadonly)?'disabled':''}}>
                        <option value="0" disabled selected>--- Select a Document Status ---</option>
                        @foreach ($statuses as $status)
                        @if (isset($document) && $document->status == $status)
                        <option value="{{$status}}" selected>{{$status}}</option>
                        @else
                        <option value="{{$status}}">{{$status}}</option>
                        @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row mb-4">
                <label class="col-sm-2 col-form-label">Start Date<b class="required">*</b>:</label>
                <div class="col-sm-10">
                    <div class="input-group date">
                        <input id="startdate" name="startdate" value="{{isset($document)?$document->start_date:''}}" type="text" class="form-control" placeholder="click to select the start date" autocomplete="off" required {{isset($isReadonly)?'disabled':''}}>
                        <span class="input-group-text">
                            <i class="fa-solid fa-calendar"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="form-group row mb-4">
                <label class="col-sm-2 col-form-label">End Date<b class="required">*</b>:</label>
                <div class="col-sm-10">
                    <div class="input-group date">
                        <input id="enddate" name="enddate" value="{{isset($document)?$document->end_date:''}}" type="text" class="form-control" placeholder="click to select the end date" autocomplete="off" {{isset($isReadonly)?'disabled':''}}>
                        <span class="input-group-text">
                            <i class="fa-solid fa-calendar"></i>
                        </span>
                    </div>
                    <div class="form-text form-check">
                        <input name="unspecifiedEndDate" class="form-check-input" type="checkbox" value="true" id="unspecifiedEndDate" {{isset($document)&&$document->end_date=='unspecified'?'checked':''}} {{isset($isReadonly)?'disabled':''}}>
                        <label class="form-check-label" for="unspecifiedEndDate">
                            Unspecified End Date
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{ __('General') }}</h6>
        </div>
        <div class="card-body">
            <div class="form-group row mb-4">
                <label class="col-sm-2 col-form-label">Document Type<b class="required">*</b>:</label>
                <div class="col-sm-10">
                    <select id="document-type" name="document-type" class="selectpicker form-control" data-live-search="true" required {{isset($isReadonly)?'disabled':''}}>
                        <option value="0" disabled selected>--- Select a Document Type ---</option>
                        @foreach ($documentTypes as $documentType)
                        @if (isset($document) && $document->documentType->shortname == $documentType->shortname)
                        <option value="{{$documentType->id}}" data-subtext="{{$documentType->shortname}}" selected>{{$documentType->name}}</option>
                        @else
                        <option value="{{$documentType->id}}" data-subtext="{{$documentType->shortname}}">{{$documentType->name}}</option>
                        @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row mb-4">
                <label class="col-sm-2 col-form-label">Document Number<b class="required">*</b>: </label>
                <div class="col-sm-10">
                    <input id="number" name="number" value="{{isset($document)?$document->number:''}}" class="form-control" type="text" placeholder="ex: B.07.1/Ma.13.22.02/PP.00.6/01/2022" required {{isset($isReadonly)?'disabled':''}}>
                </div>
            </div>
            <div class="form-group row mb-4">
                <label class="col-sm-2 col-form-label">Document Title<b class="required">*</b>: </label>
                <div class="col-sm-10">
                    <input id="title" name="title" value="{{isset($document)?$document->title:''}}" class="form-control" type="text" placeholder="ex: Agreement For Establishment of International ..." required {{isset($isReadonly)?'disabled':''}}>
                </div>
            </div>
            <div class="form-group row mb-4">
                <label class="col-sm-2 col-form-label">Description: </label>
                <div class="col-sm-10">
                    <textarea id="desc" name="desc" class="form-control" rows="6" {{isset($isReadonly)?'disabled':''}}>{{isset($document)?$document->desc:''}}</textarea>
                </div>
            </div>
            <div class="form-group row mb-4">
                <label class="col-sm-2 col-form-label">Programs:</label>
                <div class="col-sm-10">
                    <select id="programs" name="programs[]" class="selectpicker form-control" data-live-search="true" multiple>
                        @foreach ($programs as $program)
                        @if (isset($docPrograms) && in_array($program->id, $docPrograms))
                        <option value="{{$program->id}}" data-subtext="{{$program->name}}" selected>{{$program->name}}</option>
                        @else
                        <option value="{{$program->id}}" data-subtext="{{$program->name}}">{{$program->name}}</option>
                        @endif
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{ __('Parties') }}</h6>
        </div>
        <div class="card-body">
            <div class="form-group row mb-4">
                <label class="col-sm-2 fs-6"><b>Party #1</b></label>
                <div class="col-sm-10">
                </div>
            </div>
            <div class="form-group row mb-4">
                <label class="col-sm-2 col-form-label">Institution<b class="required">*</b>:</label>
                <div class="col-sm-10">
                    <select id="institution-1" name="institution[1][]" class="selectpicker form-control select-institution" data-live-search="true" required {{isset($isReadonly)?'disabled':''}}>
                        <option disabled selected>--- Select an Institution ---</option>
                        @foreach ($institutions as $institution)
                        @if (isset($docInstituions[0]) && in_array($institution->id, $docInstituions[0]))
                        <option value="{{$institution->id}}" data-subtext="{{$institution->name}}" selected>{{$institution->name}}</option>
                        @else
                        <option value="{{$institution->id}}" data-subtext="{{$institution->institutionType->name}}">{{$institution->name}}</option>
                        @endif
                        @endforeach
                    </select>
                    <div id="party1help" class="form-text">hint: select our institution here!</div>
                </div>
            </div>
            <div class="form-group row mb-4">
                <label class="col-sm-2 col-form-label">Units:</label>
                <div class="col-sm-10">
                    @if (isset($isReadonly) && isset($docUnits))
                    <div style="margin-top: 8px;">
                        @foreach($docUnits as $key => $docUnit)
                        @if ($docUnit[0][0] == 1)
                        <li>
                            {{ $docUnit[1][0]->name }}
                        </li>
                        @endif
                        @endforeach
                    </div>
                    @else
                    <select id="unit-1" name="units[1][]" class="selectpicker form-control select-unit" data-live-search="true" multiple></select>
                    @endif
                </div>
            </div>
            <hr />
            <div class="form-group row mb-4">
                <label class="col-sm-2 fs-6"><b>Party #2</b></label>
                <div class="col-sm-10">
                </div>
            </div>
            <div class="form-group row mb-4">
                <label class="col-sm-2 col-form-label">Institution<b class="required">*</b>:</label>
                <div class="col-sm-10">
                    <select id="institution-2" name="institution[2][]" class="selectpicker form-control select-institution" data-live-search="true" required {{isset($isReadonly)?'disabled':''}}>
                        <option disabled selected>--- Select an Institution ---</option>
                        @foreach ($institutions as $institution)
                        @if (isset($docInstituions[1]) && in_array($institution->id, $docInstituions[1]))
                        <option value="{{$institution->id}}" data-subtext="{{$institution->name}}" selected>{{$institution->name}}</option>
                        @else
                        <option value="{{$institution->id}}" data-subtext="{{$institution->institutionType->name}}">{{$institution->name}}</option>
                        @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row mb-4">
                <label class="col-sm-2 col-form-label">Units:</label>
                <div class="col-sm-10">
                    @if (isset($isReadonly) && isset($docUnits))
                    <div style="margin-top: 8px;">
                        @foreach($docUnits as $key => $docUnit)
                        @if ($docUnit[0][0] == 2)
                        <li>
                            {{ $docUnit[1][0]->name }}
                        </li>
                        @endif
                        @endforeach
                    </div>
                    @else
                    <select id="unit-2" name="units[2][]" class="selectpicker form-control select-unit" data-live-search="true" multiple></select>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{ __('File') }}</h6>
        </div>
        <div class="card-body">
            @if (isset($document))
            <div class="form-group row mb-4">
                <label class="col-sm-2 col-form-label">Download:</label>
                <div class="col-sm-10">
                    <div class="input-group">
                        <input type="text" class="form-control" value="{{$document->file}}" aria-label="download file" aria-describedby="download-file" disabled>
                        <a href="{{route('document.download', $document->id)}}" target="_blank" class="btn btn-primary" type="button" id="download-file">Download Document</a>
                    </div>
                </div>
            </div>
            @endif
            @if (!isset($isReadonly))
            <div class="form-group row mb-4">
                <label class="col-sm-2 col-form-label">{!!(isset($document)?'Replace Document':'Upload<b class="required">*</b>')!!}:</label>
                <div class="col-sm-10">
                    <input name="document" type="file" class="form-control" aria-label="file" accept="application/pdf" {{(isset($document)?'':'required')}}>
                </div>
            </div>
            @endif
        </div>
    </div>
    @if (!isset($isReadonly))
    <div class="card shadow mb-4">
        <div class="card-body">
            <div style="float: right;">
                <a href="{{route('documents')}}" class="btn btn-secondary">Cancel/Back</a>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
    @else
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">{{ __('Predecessor Document(s)') }}</h6>
            <h6 id="renewed-count" class="m-0 font-weight-regular">Renewed {{ $countTree }} time(s)</h6>
        </div>
        <div class="card-body">
            <div id="document-table"></div>
        </div>
    </div>
    @endif
</form>
@endsection

@section('script')
<script type="text/javascript">
    if ($('input#unspecifiedEndDate').is(':checked')) {
        $('input#enddate').attr('disabled', true)
        $('input#enddate').attr('required', false)
    }
    $('input#unspecifiedEndDate').change(function() {
        if (this.checked) {
            $('input#enddate').attr('disabled', true)
            $('input#enddate').attr('required', false)
            $('input#enddate').val('unspecified');
        } else {
            $('input#enddate').attr('disabled', false)
            $('input#enddate').attr('required', true)
            $('input#enddate').val('');
        }
    });
    $('.date input').datepicker({});
    var capitalize = (str) => {
        return str.charAt(0).toUpperCase() + str.slice(1);
    }
    $('.select-institution').on('change', function(e) {
        var id = $(this).attr('id').replace(/^\D+/g, '')
        $(`#unit-${id}`).find('option').remove()
        $(`#unit-${id}`).selectpicker('refresh')
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        var url = '{{ route("unit.data", ":id") }}';
        url = url.replace(':id', $(this).find("option:selected").val().toString());
        $.ajax({
            url: url,
            method: 'get',
            data: {},
            success: function(result) {
                var unitSelect = $(`#unit-${id}`);
                var tree = (arr) => {
                    arr.forEach(el => {
                        unitSelect.append('<option data-subtext=' + capitalize(el.label) + ' value=' + el.id + '>' + el.name + '</option>');
                        if (el._children.lenght != 0) {
                            tree(el._children)
                        }
                    });
                }
                tree(result)
                unitSelect.selectpicker('refresh');
            }
        });
    });
    @if(isset($isReadonly))
    var showIcon = function(cell, formatterParams) {
        return '<i class="fa-solid fa-eye text-info"></i>';
    };
    var table = new Tabulator("#document-table", {
        placeholder: "No data",
        layout: "fitColumns",
        dataTree: true,
        dataTreeStartExpanded: true,
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
                }]
            },
        ]
    });
    table.on("tableBuilt", function() {
        table.setData("{{route('document.predecessor.data', $id)}}");
        $('input[type=search]').attr("placeholder", "search..");
        $('input[type=search]').addClass('form-control');
        $('input[type=search]').css({
            'height': 'auto'
        });
    });
    @endif
    @if(isset($docInstituions))
    $(document).ready(function(e) {
        var units = @json($docUnits);
        var institutions = @json($docInstituions);
        institutions.forEach((institution, idx) => {
            var parties = Object.keys(institution)
            var url = '{{ route("unit.data", ":id") }}';
            url = url.replace(':id', institutions[idx][parties[0]].toString());
            var iu = [];
            console.log(url, institutions[idx][parties[0]])
            units.forEach((unit, i) => {
                if (parties[0] == units[i][0]) {
                    console.log(units[i][1][0], parties[0])
                    iu.push(units[i][1][0])
                }
            });
            $.ajax({
                url: url,
                method: 'get',
                data: {},
                success: function(result) {
                    var unitSelect = $(`#unit-${parties[0]}`);
                    var tree = (arr) => {
                        arr.forEach((el) => {
                            if (iu.includes(el.id)) {
                                unitSelect.append('<option data-subtext="' + capitalize(el.label) + '" value="' + el.id + '" selected>' + el.name + '</option>');
                            } else {
                                unitSelect.append('<option data-subtext=' + capitalize(el.label) + ' value=' + el.id + '>' + el.name + '</option>');
                            }
                            if (el._children.lenght != 0) {
                                tree(el._children)
                            }
                        });
                    }
                    tree(result)
                    unitSelect.selectpicker('refresh');
                }
            });
        });
    });
    @endif
</script>
@endsection