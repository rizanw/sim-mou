<div id="partner-by-country-table"></div>

@section('topPartnerByCountry')
<script type="text/javascript">
    var flagName = function(cell, formatterParams) {
        return `<span class="fi fi-${cell.getRow().getData().id.toLowerCase()}"></span> ${cell.getRow().getData().name}`;
    };
    var table = new Tabulator("#partner-by-country-table", {
        placeholder: "No data",
        layout: "fitColumns",
        paginationSize: 10,
        columns: [{
                title: "No",
                formatter: "rownum",
                width: 60
            },
            {
                title: "Name",
                formatter: flagName,
            },
            {
                title: "Number",
                field: "number",
            },
        ]
    });
    table.on("tableBuilt", function() {
        table.setData("{{route('chart.partner.byCountry')}}");
    });
</script>
@endsection