@extends('layouts.app')

@section('pagetitle', 'Users')

@section('content')
<div>
    <div class="card shadow mb-4">
        <div class="card-header">{{ __('Console') }}</div>
        <div class="card-body">
            <a href="{{route('user.create')}}" class="btn btn-primary btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fa-solid fa-plus"></i>
                </span>
                <span class="text">Add User</span>
            </a>
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{ __('Table') }}</h6>
        </div>
        <div class="card-body">
            <div id="user-table"></div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
    var showIcon = function(cell, formatterParams) {
        return '<i class="fa-solid fa-eye text-info"></i>';
    };
    var table = new Tabulator("#user-table", {
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
                title: "Email",
                field: "email",
                headerFilter: true
            },
            {
                title: "Action",
                columns: [{
                    title: "show",
                    formatter: showIcon,
                    width: 80,
                    hozAlign: "center",
                    cellClick: function(e, cell) {
                        var url = '{{ route("user.show", ":id") }}';
                        url = url.replace(':id', cell.getRow().getData().id.toString());
                        location.href = url
                    }
                }]
            },
        ]
    });
    table.on("tableBuilt", function() {
        table.setData("{{route('user.data')}}");
        $('input[type=search]').attr("placeholder", "search..");
        $('input[type=search]').addClass('form-control');
        $('input[type=search]').css({
            'height': 'auto'
        });
    });
</script>
@endsection