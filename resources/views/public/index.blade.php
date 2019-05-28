@include('layouts.header')
@include('layouts.nav_bar')
@include('layouts.side_bar')

<div class="content-wrapper pl-2 pt-2">
    
    <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row ">
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-info elevation-1"><i class="fa fa-gear"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">AVERAGE SPEED</span>
                        <span class="info-box-number">
                            {{$overall_av_speed}}
                            <small>km/hr</small>
                        </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-info elevation-1"><i class="fa fa-gear"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">AVERAGE SPEED <span class="text-secondary">(Today)</span>
                        <span class="info-box-number">
                            {{ $today_av_speed }}
                            <small>km/hr</small>
                        </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-danger elevation-1"><i class="fa fa-google-plus"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">PENALTIES</span>
                        <span class="info-box-number">{{$total_penalties}}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->

            <!-- fix for small devices only -->
            <div class="clearfix hidden-md-up"></div>

            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-success elevation-1"><i class="fa fa-shopping-cart"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">NUMBER OF VEHICLES</span>
                        <span class="info-box-number">{{$total_buses}}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            
        </div>
        <div class="row mt-2">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Report</div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="container" id="averageLine">

                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="container" id="pie_av">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <ul class="nav nav-tabs" id="myTab" role="tablist" ml="auto">
                <li class="nav-item">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                        aria-controls="home" aria-selected="true">Tab 1</a>
                </li>

            </ul>
            <div class="tab-content container-fluid" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <h2 class=" text-center mt-3">Top 5</h2>
                    <div class="row">
                        <div class="col-lg-4 ">
                            <div class="card border-transparent">
                                <div class="card-header">
                                    <h3 class="card-title">Areas with most over penalties</h3>
                                </div>
                                <div class="card-body">
                                <table class="table table-striped table-bordered table-sm">
                                        <thead class="thead-light">
                                            <tr>
                                                <th scope="col">Area</th>
                                                <th scope="col">Number of penalties</th>
                                                <th scope="col">Average Speed</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($areasWithMostPenalties as $area)
                                                <tr>
                                                    <td>{{$area->place}}</td><td>{{$area->total_penalties}}</td><td>{{$area->avg}}</td>
                                                </tr>
                                           @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 ">
                            <div class="card border-transparent">
                                <div class="card-header">
                                    <h3 class="card-title">Most over speeding bus companies</h3>
                                </div>
                                <div class="card-body">
                                    <table class="table table-striped table-bordered table-sm">
                                        <thead class="thead-light">
                                            <tr>
                                                <th scope="col">Bus Company</th>
                                                <th scope="col">Average Speed</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           @foreach($companieswithHighestAvgSpeeds as $company)
                                                <tr>
                                                    <td>{{$company->company_name}}</td><td>{{$company->avg}}</td>
                                                </tr>
                                           @endforeach
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                        <div class="col-lg-4 ">
                            <div class="card border-transparent">
                                <div class="card-header">
                                    <h3 class="card-title">Companies with most penalties</h3>
                                </div>
                                <div class="card-body">
                                    <table class="table table-striped table-bordered table-sm">
                                        <thead class="thead-light">
                                            <tr>
                                                <th scope="col">Bus Company</th>
                                                <th scope="col">Number of penalties</th>
                                                <th scope="col">Average Speed</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($companiesWithMostPenalties as $company)
                                                <tr>
                                                    <td>{{$company->company_name}}</td><td>{{$company->total_penalties}}</td><td>{{$company->avg}}</td>
                                                </tr>
                                           @endforeach
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>

    </div>

</div>

@include('layouts.footer')
<script type="text/javascript">
var pie_av_speeds = @json($pie_av_speeds);
var line_average_speeds = @json($line_average_speeds);


var months = @json($months);



Highcharts.chart('averageLine', {

    title: {
        text: 'Average Speeds for bus companies per month'
    },
    xAxis: {
 				categories: Object.keys(months),
 				crosshair: true
 			},
    yAxis: {
        title: {
            text: 'Average Speed'
        }
    },
    legend: {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'middle'
    },

    plotOptions: {
        series: {
            label: {
                connectorAllowed: false
            }
        }
    },

    series: line_average_speeds,

    responsive: {
        rules: [{
            condition: {
                maxWidth: 500
            },
            chartOptions: {
                legend: {
                    layout: 'horizontal',
                    align: 'center',
                    verticalAlign: 'bottom'
                }
            }
        }]
    }

});





// Build the chart
Highcharts.chart('pie_av', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Total Average Speeds in 2019'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.y:.1f}</b> at <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: false
            },
            showInLegend: true
        }
    },
    series: [{
        name: 'Average',
        colorByPoint: true,
        data: pie_av_speeds
    }]
});

$(document).ready(function() {
    $('#example').DataTable();
});
</script>