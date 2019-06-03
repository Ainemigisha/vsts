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
                <h3 class="card-title">Add User</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="post" action="/user">
                {{csrf_field()}}
                <div class="card-body">
                  <div class="form-group">
                    <label for="location_finder">User name</label>
                    <input type="text" name="username" class="form-control" >
                  </div>
                  <div class="form-group">
                    <label for="location_finder">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="e.g. john@gmail.com">
                  </div>
                  <div class="form-group">
                    <label for="location_finder">Password</label>
                    <input type="password" name="password" class="form-control">
                  </div>
                  <div class="form-group">
                    <label >Category </label>
                    <select id="category" name="category" class="form-control">
                        <option selected>Choose...</option>
                        <option value="police">Police Admin<option>
                        <option value="bus_admin">Bus Admin<option>
                        <option value="system_admin">System Admin<option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Role <span class="text-secondary"><i>(Optional)</i></span></label>
                    <select id="category" name="role" class="form-control">
                        <option selected>Choose...</option>
                        <option value="admin">Police Admin<option>
                        <option value="officer">Police Officer<option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" name="address" class="form-control" >
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
                <h3 class="card-title">Users</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example" class="table table-bordered">
                  <tr>
                    <th style="width: 200px">Username</th>
                    <th >Email</th>
                    <th >Category</th>
                    <th >Created at</th>
                  </tr>
                  @foreach($users as $user)
                    <tr>
                        <td>{{$user->name}}</td><td>{{$user->email}}</td><td>{{$user->category}}</td><td>{{$user->created_at->toDayDateTimeString()}}</td>
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
<script type="text/javascript">
$(document).ready(function() {
    $('#example').DataTable();
});
</script>