<canvas id="document-by-continent"></canvas>

@section('docByContinent')
<script type="text/javascript">
    var colors = ['rgba(5, 15, 44, 1)', 'rgba(0, 54, 102, 1)', 'rgba(0, 174, 255, 1)', 'rgba(51, 105, 231, 1)', 'rgba(142, 67, 231, 1)', 'rgba(184, 69, 146, 1)', 'rgba(255, 79, 129, 1)', 'rgba(255, 108, 95, 1)', 'rgba(255, 193, 104, 1)', 'rgba(45, 222, 152, 1)', 'rgba(28, 199, 208, 1)'].reverse();
    $(document).ready(function() {
        $.ajax({
            type: 'GET',
            url: '{{route("chart.document.byContinent")}}',
            dataType: "json",
            success: function(response) {
                const labels = [];
                const data = [];
                response.forEach(el => {
                    labels.push(el[0])
                    data.push(el[1])
                });
                const config = {
                    type: 'doughnut',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Document Number By Continent',
                            data: data,
                            backgroundColor: colors,
                        }],
                    },
                    options: {}
                };
                new Chart(
                    document.getElementById('document-by-continent'),
                    config
                );
            }

        });
    });
</script>
@endsection