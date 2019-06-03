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
              <form method="post" action="add_company">
                {{csrf_field()}}
                <div class="card-body">
                  <div class="form-group">
                    <label for="company">Company Name</label>
                    <input type="text" name="company_name" class="form-control" id="company" >
                  </div>
                  <div class="form-group">
                    <label >Bus administrator </label>
                    <select id="admin_id" name="admin_id" class="form-control">
                        <option selected>Choose...</option>
                        @foreach($admins as $admin)
                            <option value="{{$admin->id}}">{{$admin->name}}</option>
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
                <h3 class="card-title">Bus Companies</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered">
                  <tr>
                    <th style="width: 200px">Company Name</th>
                    <th >Administrator</th>
                    <th >Created at</th>
                  </tr>
                  @foreach($all_companies as $company)
                    <tr>
                        <td>{{$company->company_name}}</td> <td>{{$company->adminId->user->name}}</td><td>{{$company->created_at->toDayDateTimeString()}}</td>
                    </tr>
                  @endforeach
                </table>
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