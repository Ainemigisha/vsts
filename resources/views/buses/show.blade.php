@include('layouts.header')
<body class="hold-transition sidebar-mini">
<div class="wrapper">

@include('layouts.nav_bar')

<!-- Main Sidebar Container -->
@include('layouts.side_bar')
    <!-- Main content -->
    <div class="content-wrapper">
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <p><hr></p>
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Bus Profile</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
                <div class="card-body">
                <table class="table table-bordered table-sm">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">Property</th>
                            <th scope="col">Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Number Plate</td>
                            <td>{{$bus_profile->number_plate}}</td>
                        </tr>
                        <tr>
                            <td>Bus Company</td>
                            <td>{{$bus_profile->bus_company->company_name}}</td>
                        </tr>
                        <tr>
                            <td>Penalties  <span class="text-secondary">"Overall"</span></td>
                            <td>{{$bus_stat_overall->total_penalties}}</td>
                        </tr>
                        <tr>
                            <td>Penalties  <span class="text-secondary">"Today"</span></td>
                            <td>{{$bus_stat_today->total_penalties}}</td>
                        </tr>
                        <tr>
                            <td>Average Speed <span class="text-secondary">"Overall"</span></td>
                            <td>{{$bus_stat_overall->avg}}</td>
                        </tr>
                        <tr>
                            <td>Average Speed <span class="text-secondary">"Today"</span></td>
                            <td>{{$bus_stat_today->avg}}</td>
                        </tr>
                    </tbody>
                </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                </div>
            </div>
          </div> 
        </div>
        <div class="row">
          <div class="col-md-7">
          <div class="card">
            <div class="card-body">
                
                  <div class = "chart" id="averageLine" style="min-width: 310px; max-width: 800px; height: 300px; margin: 0 auto">
                  </div>
                  <!-- /.chart-responsive -->
            </div>
            
          </div>
        </div>
        <div class="col-md-5">
            <div class="card border-transparent">
                <div class="card-header">
                    <h3 class="card-title">Penalties</h3>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-bordered table-sm">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Speed</th>
                                <th scope="col">Assigned by</th>
                                <th scope="col">Assigned On</th>
                                <th scope="col">Cleared by</th>
                                <th scope="col">Cleared On</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                                @foreach($penalties as $penalty)
                                    @if(!is_null($penalty->speed))
                                    <tr>
                                        <td>{{$penalty->speed}}</td>
                                        <td>{{$penalty->assigner_name}}</td>
                                        <td>{{\Carbon\Carbon::parse($penalty->assigned_on)->toDayDateTimeString()}}</td>
                                        <td>{{$penalty->clearer_name}}</td>
                                        <td>{{\Carbon\Carbon::parse($penalty->cleared_date)->toDayDateTimeString()}}<td>
                                    <tr>
                                    @endif
                                @endforeach
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        </div>
      </div>
    </section>
  </div>
            <!-- /.card -->
@include('layouts.footer')
<script type="text/javascript">

var bus_name = "<?php echo $bus_profile->number_plate ?>";
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

series:[{
        name: bus_name,
        data: line_average_speeds
    }],

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

$(document).ready(function() {
    $('#example').DataTable();
});
</script>