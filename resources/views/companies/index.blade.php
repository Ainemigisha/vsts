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
                <h3 class="card-title">Add Bus Company</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="post" action="/add_location_finder" >
                {{csrf_field()}}
                <div class="card-body">
                <div class="form-group">
                    <label >Bus number plate </label>
                    <select id="num_plate" name="bus" class="form-control">
                        <option selected>Choose...</option>
                        @foreach($buses as $bus)
                            <option value="{{$bus->id}}">{{$bus->number_plate}}</option>
                        @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label >Device </label>
                    <select id="device" name="device" class="form-control">
                        <option selected>Choose...</option>
                        @foreach($devices as $device)
                            <option value="{{$device->alphanumeric_string}}">{{$device->alphanumeric_string}}</option>
                        @endforeach
                    </select>
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
                <h3 class="card-title">Location Finders</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered">
                  <tr>
                    <th>Number plate</th>
                    <th>Device</th>
                    <th>Created at</th>
                  </tr>
                  @foreach($location_finders as $location_finder)
                    <tr>
                    <td>{{$location_finder->bus->number_plate}}</td><td>{{$location_finder->device->alphanumeric_string}}</td><td>{{$location_finder->created_at->toDayDateTimeString()}}</td>
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