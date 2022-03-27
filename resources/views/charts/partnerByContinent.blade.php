<canvas id="partner-by-continent"></canvas>

@section('partnerByContinent')
<script type="text/javascript">
    var colors = ['rgba(5, 15, 44, 1)', 'rgba(0, 54, 102, 1)', 'rgba(0, 174, 255, 1)', 'rgba(51, 105, 231, 1)', 'rgba(142, 67, 231, 1)', 'rgba(184, 69, 146, 1)', 'rgba(255, 79, 129, 1)', 'rgba(255, 108, 95, 1)', 'rgba(255, 193, 104, 1)', 'rgba(45, 222, 152, 1)', 'rgba(28, 199, 208, 1)'].reverse();
    $(document).ready(function() {
        $.ajax({
            type: 'GET',
            url: '{{route("chart.partner.byContinent")}}',
            dataType: "json",
            success: function(response) {
                const labels = [];
                const data = [];
                response.forEach(el => {
                    labels.push(el[0])
                    data.push(el[1])
                });
                console.log(labels, data)
                const config = {
                    type: 'pie',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Partner Number By Continent',
                            data: data,
                            backgroundColor: colors,
                        }],
                    },
                    options: {}
                };
                new Chart(
                    document.getElementById('partner-by-continent'),
                    config
                );
            }

        });
    });
</script>
@endsection