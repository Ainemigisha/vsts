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
                            <td></td>
                        </tr>
                        <tr>
                            <td>Bus Company</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Penalties</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Overall Average Speed</td>
                            <td></td>
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
                                <th scope="col">#</th>
                                <th scope="col">Location</th>
                                <th scope="col">Date Issued</th>
                                <th scope="col">Date Cleared</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>Mbarara</td>
                                <td>12/03/2019</td>
                                <td>12/03/2019</td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td>Masaka</td>
                                <td>12/04/2018</td>
                                <td>9/03/2019</td>
                            </tr>
                            <tr>
                                <th scope="row">3</th>
                                <td>Lukaya</td>
                                <td>4/12/2018</td>
                                <td>01/10/2019</td>
                            </tr>
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
Highcharts.chart('averageLine', {

    title: {
        text: 'Average Speed'
    },

    yAxis: {
        title: {
            text: 'Speed'
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
            },
            pointStart: 2010
        }
    },

    series: [{
        name: 'Speed',
        data: [24916, 24064, 29742, 29851, 32490, 30282, 38121, 40434]
    },{
        name: 'Other',
        data: [12908, 5948, 8105, 11248, 8989, 11816, 18274, 18111]
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