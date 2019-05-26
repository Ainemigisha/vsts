@include('layouts.header')
@include('layouts.nav_bar')
@include('layouts.side_bar')

<div class="content-wrapper pl-2 pt-2">
    <div class="container-fluid">
        <div class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fa fa-gear"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">AVERAGE SPEED</span>
                <span class="info-box-number">
                  300                 
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
                <span class="info-box-number">200</span>
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
                <span class="info-box-number">760</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fa fa-users"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">OTHER</span>
                <span class="info-box-number">2,000</span>
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

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                  </button>
                  <div class="btn-group">
                    <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
                      <i class="fa fa-wrench"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" role="menu">
                      <a href="#" class="dropdown-item">Action</a>
                      <a href="#" class="dropdown-item">Another action</a>
                      <a href="#" class="dropdown-item">Something else here</a>
                      <a class="dropdown-divider"></a>
                      <a href="#" class="dropdown-item">Separated link</a>
                    </div>
                  </div>
                  <button type="button" class="btn btn-tool" data-widget="remove">
                    <i class="fa fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12">
                      <div class="card card-body">
                    <div class = "chart" id="averageLine"></div>
                      </div>

                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                  <div class="card card-body">
                    <div class = "chart" id="penaltyLine"></div>
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
                                    <h3 class="card-title">Areas with overspeeding</h3>
                                </div>
                                <div class="card-body">
                                    <table class="table table-striped table-bordered table-sm">
                                        <thead class="thead-light">
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Place</th>
                                                <th scope="col">Average Speed</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th scope="row">1</th>
                                                <td>Mark</td>
                                                <td>Otto</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">2</th>
                                                <td>Jacob</td>
                                                <td>Thornton</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">3</th>
                                                <td>Larry</td>
                                                <td>the Bird</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 ">
                            <div class="card border-transparent">
                                <div class="card-header">
                                    <h3 class="card-title">Most over speeding buses</h3>
                                </div>
                                <div class="card-body">
                                    <table class="table table-striped table-bordered table-sm">
                                        <thead class="thead-light">
                                            <tr>
                                                <th scope="col">Number Plate</th>
                                                <th scope="col">Average Speed</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           @foreach($buseswithHighestAvgSpeeds as $bus)
                                                <tr>
                                                    <td>{{$bus->number_plate}}</td><td>{{$bus->avg}}</td>
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
                                    <h3 class="card-title">Buses with most penalties</h3>
                                </div>
                                <div class="card-body">
                                    <table class="table table-striped table-bordered table-sm">
                                        <thead class="thead-light">
                                            <tr>
                                                <th scope="col">Number Plate</th>
                                                <th scope="col">Number of penalties</th>
                                                <th scope="col">Average Speed</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($busesWithMostPenalties as $bus)
                                                <tr>
                                                    <td>{{$bus->number_plate}}</td><td>{{$bus->total_penalties}}</td><td>{{$bus->avg}}</td>
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

<script type="text/javascript">


var company_name = "<?php echo $company_name ?>";
var line_average_speeds = @json($line_average_speeds);
var line_sum_penalties = @json($line_sum_penalties);
var months = @json($months);

Highcharts.chart('averageLine', {

title: {
    text: 'Average Speeds for '+company_name+' per month'
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
        name: company_name,
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


Highcharts.chart('penaltyLine', {

title: {
    text: 'Sum of penalties for '+company_name+' per month'
},
xAxis: {
             categories: Object.keys(months),
             crosshair: true
         },
yAxis: {
    title: {
        text: 'Sum of penalties'
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
        name: company_name,
        data: line_sum_penalties
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




</script>

@include('layouts.footer')