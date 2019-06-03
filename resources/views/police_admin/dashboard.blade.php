@include('layouts.header')
<body class="hold-transition sidebar-mini">
<div class="wrapper">

@include('layouts.nav_bar')

@include('layouts.side_bar')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper pl-2 pt-2">
      <div class="container-fluid">
      <div class="row ">
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-info elevation-1"></span>

                    <div class="info-box-content">
                        <span class="info-box-text">TOTAL PENALTIES</span>
                        <span class="info-box-number">
                            {{$total_penalties}}
                            <small>km/hr</small>
                        </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-info elevation-1"></span>

                    <div class="info-box-content">
                        <span class="info-box-text">PROVISIONAL PENALTIES</span>
                        <span class="info-box-number">
                            {{ $provisional_total_penalties }}
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
                    <span class="info-box-icon bg-danger elevation-1"></span>

                    <div class="info-box-content">
                        <span class="info-box-text">ASSIGNED PENALTIES</span>
                        <span class="info-box-number">{{$pending_total_penalties}}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <!-- /.col -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-danger elevation-1"></span>

                    <div class="info-box-content">
                        <span class="info-box-text">CLEARED PENALTIES</span>
                        <span class="info-box-number">{{$cleared_total_penalties}}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->

            
        </div>

        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h5 class="card-title">Statistics</h5>

                
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  <div class="col-md-8">
                    <div class = "chart" id="line-basic-chart"></div>

                  </div>
                  <div class="col-md-4">
                    <div class = "chart-responsive" id="pie-chart-penalty" ></div>
                  </div>

                  
                </div>
              </div>
            </div>
          </div>
        </div>

      

        <div class="row">
          <div class="col-md-12">
              <!-- TABLE: LATEST ORDERS -->
              <div class="card">
                <div class="card-header border-transparent">
                  <h3 class="card-title">Most Recent Penalties</h3>

                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-widget="collapse">
                      <i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-widget="remove">
                      <i class="fa fa-times"></i>
                    </button>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                  <div class="table-responsive">
                  <table id="example" class=" display table table-striped table-bordered " >
                  <thead>
                  <tr>
                    <th>Company</th>
                    <th>Number Plate</th>
                    <th>Assigned By</th>
                    <th>Date of Assignment</th>
                    <th>Place</th>
                    <th>Speed</th>
                    <th>Status</th>
                    <th>Cleared By</th>
                    <th>Date of Clearance</th>
                    <th>Date of Creation</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                
            @foreach ($penalties as $penalty)
              <tr>
                <td>{{$penalty->locationFinder->bus->bus_company->company_name}}</td>
                <td>{{$penalty->locationFinder->bus->number_plate}}</td>
                @if ( $penalty->status != 'Provisional')
                <td>{{$penalty->assigner->user->name}}</td>
                <td>{{$penalty->assigned_date->toDayDateTimeString()}}</td>
                @else
                <td></td>
                <td></td>
                @endif
                
                <td>{{$penalty->place}}</td>
                <td>{{$penalty->speed}}</td>
                <td>{{$penalty->status}}</td>
                <td>@if ($penalty->status != 'pending' && $penalty->status != 'provisional')
                  {{$penalty->clearer->user->name}}
                  @endif
                </td>
                <td>
                  @if ($penalty->status != 'pending' && $penalty->status != 'provisional')
                  {{$penalty->cleared_date->toDayDateTimeString()}}
                  @endif
                </td>
                <td>{{$penalty->created_at->toDayDateTimeString()}}</td>
                <td>
                  @if ($penalty->status == 'pending' && Auth::user()->category == 'police')
                  <form method="post" action="/penalty_clear">
                    {{csrf_field()}}
                    <input type="hidden" value="{{$penalty->id}}" name="penalty_id"/>
                    <button type="submit" class="btn btn-sm btn-outline-primary">Clear</button>
                    </form>
                    
                  @endif
                </td>
              </tr>
            @endforeach

            </tbody>
            <tfoot>
                <tr>
                    <th>Company</th>
                    <th>Number Plate</th>
                    <th>Assigned By</th>
                    <th>Date of Assignment</th>
                    <th>Location</th>
                    <th>Status</th>
                    <th>Cleared By</th>
                    <th>Date of Clearance</th>
                    <th></th>
                </tr>
            </tfoot>
      </table>
                  </div>
                  <!-- /.table-responsive -->
                  </div>
                  <!-- /.card-body -->
                  <div class="card-footer clearfix">
                    <a href="javascript:void(0)" class="btn btn-sm btn-info float-left"></a>
                    <a href="javascript:void(0)" class="btn btn-sm btn-secondary float-right"></a>
                  </div>
              <!-- /.card-footer -->
            </div>
          </div>
        </div>

      </div>
  </div>
 
  <script type="text/javascript">
var months = @json($months);
var line_total_penalties = @json($line_total_penalties);
Highcharts.chart('line-basic-chart', {

    title: {
        text: 'Number of Penalties Penalties Per Month'
    },

    yAxis: {
        title: {
            text: 'Number of Penalties'
        }
    },
    legend: {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'middle'
    },

    xAxis: {
        categories: Object.keys(months),
        crosshair: true
    },

    series: line_total_penalties,

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

var pie_total_penalties = @json($pie_total_penalties);
console.log(pie_total_penalties);

Highcharts.chart('pie-chart-penalty', {
    chart: {
        type: 'pie',
        options3d: {
            enabled: true,
            alpha: 45,
            beta: 0
        }
    },
    title: {
        text: 'Average Penalties per bus company'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.y:.1f}</b> at <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            depth: 35,
            dataLabels: {
                enabled: true,
                format: '{point.name}'
            }
        }
    },
    series:[{
        name: 'Penalties',
        colorByPoint: true,
        data: pie_total_penalties
    }]
});


</script>


  @include('layouts.footer')
  


