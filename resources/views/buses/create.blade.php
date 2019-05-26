@include('layouts.header')
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Main Sidebar Container -->
@include('layouts.side_bar')
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card">
              <div class="card-header">
                <h3 >Add Bus Details</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="post" action="/add_bus">
                {{csrf_field()}}
                <div class="card-body">
                    <div class="form-group">
                        <label for="company">Bus Company</label>
                        <select id="company" class="form-control" name="company">
                            <option selected>Choose...</option>
                            @foreach($bus_companies as $company)
                                <option value="{{$company->id}}">{{$company->company_name}}</option>
                            @endforeach
                        </select>
                    </div>
                  <div class="form-group">
                    <label for="num_plate">Number Plate</label>
                    <input type="text" class="form-control" id="num_plate" placeholder="e.g UAA 245U" name="num_plate">
                  </div>
                  <div class="form-group">
                    <label for="driver_name">Driver's Name</label>
                    <input type="text" class="form-control" id="driver_name" placeholder="e.g Benjamin Mwesiga" name="driver_name">
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
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
</div>
@include('layouts.footer')