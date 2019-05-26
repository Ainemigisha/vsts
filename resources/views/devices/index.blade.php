@include('layouts.header')
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Main Sidebar Container -->
@include('layouts.side_bar')
    <!-- Main content -->
    <div class="content-wrapper">
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-6">
            <!-- general form elements -->
            <p><hr></p>
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Add Device</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="post" action="add_device">
                {{csrf_field()}}
                <div class="card-body">
                  <div class="form-group">
                    <label for="location_finder">Device alphanumericstring</label>
                    <input type="text" name="alpha_string" class="form-control" id="location_finder" placeholder="e.g. XXX01">
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
            <!-- /.card -->
          </div>
          <div class="col-md-6">
          <p><hr></p>
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Devices</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered">
                  <tr>
                    <th style="width: 200px">Device ID</th>
                    <th >Created at</th>
                  </tr>
                  @foreach($devices as $device)
                    <tr>
                        <td>{{$device->alphanumeric_string}}</td><td>{{$device->created_at->toDayDateTimeString()}}</td>
                    </tr>
                  @endforeach
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
                <ul class="pagination pagination-sm m-0 float-right">
                  <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                  <li class="page-item"><a class="page-link" href="#">1</a></li>
                  <li class="page-item"><a class="page-link" href="#">2</a></li>
                  <li class="page-item"><a class="page-link" href="#">3</a></li>
                  <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                </ul>
              </div>
            </div>
            <!-- /.card -->
          </div>
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
</div>
@include('layouts.footer')