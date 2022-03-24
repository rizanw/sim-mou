@extends('layouts.app')

@section('pagetitle', $pageTitle)

@section('content')
<form id="documentForm" action="{{$url}}" method="post" enctype="multipart/form-data">
    @method('post')
    @csrf
    <input id="id" name="id" value="{{isset($document)?$document->id:''}}" type="hidden">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{ __('Validity Period') }}</h6>
        </div>
        <div class="card-body">
            <div class="form-group row mb-4">
                <label class="col-sm-2 col-form-label">Status<b class="required">*</b>:</label>
                <div class="col-sm-10">
                    <select id="status" name="status" class="selectpicker form-control" data-live-search="true" required>
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
                        <input id="startdate" name="startdate" value="{{isset($document)?$document->start_date:''}}" type="text" class="form-control" placeholder="click to select the start date" autocomplete="off" required>
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
                        <input id="enddate" name="enddate" value="{{isset($document)?$document->end_date:''}}" type="text" class="form-control" placeholder="click to select the end date" autocomplete="off">
                        <span class="input-group-text">
                            <i class="fa-solid fa-calendar"></i>
                        </span>
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
                    <select id="document-type" name="document-type" class="selectpicker form-control" data-live-search="true" required>
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
                    <input id="number" name="number" value="{{isset($document)?$document->number:''}}" class="form-control" type="text" placeholder="ex: B.07.1/Ma.13.22.02/PP.00.6/01/2022" required>
                </div>
            </div>
            <div class="form-group row mb-4">
                <label class="col-sm-2 col-form-label">Document Title<b class="required">*</b>: </label>
                <div class="col-sm-10">
                    <input id="title" name="title" value="{{isset($document)?$document->title:''}}" class="form-control" type="text" placeholder="ex: Agreement For Establishment of International ..." required>
                </div>
            </div>
            <div class="form-group row mb-4">
                <label class="col-sm-2 col-form-label">Description: </label>
                <div class="col-sm-10">
                    <textarea id="desc" name="desc" class="form-control" rows="6">{{isset($document)?$document->desc:''}}</textarea>
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
                    <select id="institution-1" name="institution[1][]" class="selectpicker form-control select-institution" data-live-search="true" required>
                        <option disabled selected>--- Select an Institution ---</option>
                        @foreach ($institutions as $institution)
                        @if (isset($docInstituions[0]) && in_array($institution->id, $docInstituions[0]))
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
                    <select id="unit-1" name="units[1][]" class="selectpicker form-control select-unit" data-live-search="true" multiple>
                    </select>
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
                    <select id="institution-2" name="institution[2][]" class="selectpicker form-control select-institution" data-live-search="true" required>
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
                    <select id="unit-2" name="units[2][]" class="selectpicker form-control select-unit" data-live-search="true" multiple>
                    </select>
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
            <div class="form-group row mb-4">
                <label class="col-sm-2 col-form-label">{{(isset($document)?'Replace Document':'Upload<b class="required">*</b>')}}:</label>
                <div class="col-sm-10">
                    <input name="document" type="file" class="form-control" aria-label="file" accept="application/pdf" {{(isset($document)?'':'required')}}>
                </div>
            </div>
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-body">
            <div style="float: right;">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</form>
@endsection

@section('script')
<script type="text/javascript">
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
    @if(isset($docInstituions))
    $(document).ready(function(e) {
        var units = @json($docUnits);
        var institutions = @json($docInstituions);
        institutions.forEach((institution, idx) => {
            var parties = Object.keys(institution)
            var url = '{{ route("unit.data", ":id") }}';
            url = url.replace(':id', institutions[idx][parties[0]].toString());
            var iu = [];
            console.log(url,institutions[idx][parties[0]])
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