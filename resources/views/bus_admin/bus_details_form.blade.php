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
              <form role="form">
                <div class="card-body">
                    <div class="form-group">
                        <label for="company">Bus Company</label>
                        <select id="company" class="form-control">
                            <option selected>Choose...</option>
                            <option>Global Bus Company</option>
                            <option>Gaaga Bus Company</option>
                            <option>Link Bus Company</option>
                        </select>
                    </div>
                  <div class="form-group">
                    <label for="num_plate">Number Plate</label>
                    <input type="text" class="form-control" id="num_plate" placeholder="e.g UAA 245U">
                  </div>
                  <div class="form-group">
                    <label for="driver_name">Driver's Name</label>
                    <input type="text" class="form-control" id="driver_name" placeholder="e.g Benjamin Mwesiga">
                  </div>
                  <div class="form-group">
                    <label for="loc_finder_id">Location Finder ID </label>
                    <select id="loc_finder_id" class="form-control">
                        <option selected>Choose...</option>
                        <option>XXXX1</option>
                        <option>XXXX2</option>
                        <option>XXXX3</option>
                    </select>
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