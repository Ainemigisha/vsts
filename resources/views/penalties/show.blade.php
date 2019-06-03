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
                <h3 class="card-title">Penalty Profile</h3>
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
                            <td>{{$penalty->locationFinder->bus->number_plate}}</td>
                        </tr>
                        <tr>
                            <td>Bus Company</td>
                            <td>{{$penalty->locationFinder->bus->bus_company->company_name}}</td>
                        </tr>
                        <tr>
                            <td>Culprit</td>
                            <td>{{$penalty->locationFinder->driver_name}}</td>
                        </tr>
                        @if ($penalty->status != 'Provisional')
                        <tr>
                            <td>Assigned By</td>
                            <td>{{$penalty->assigner->user->name}}</td>
                        </tr>
                        <tr>
                            <td>Date of Assignment</td>
                            <td>{{$penalty->assigned_date->toDayDateTimeString()}}</td>
                        </tr>
                        @endif
                        <tr>
                            <td>Place</td>
                            <td>{{$penalty->place}}</td>
                        </tr>
                        <tr>
                            <td>Speed</td>
                            <td>{{$penalty->speed}}</td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td>{{$penalty->status}}</td>
                        </tr>
                        @if ($penalty->status != 'pending' && $penalty->status != 'provisional')
                        <tr>
                            <td>Cleared By</td>
                            <td>{{$penalty->clearer->user->name}}</td>
                        </tr>
                        <tr>
                            <td>Date of Clearance</td>
                            <td>{{$penalty->cleared_date->toDayDateTimeString()}}</td>
                        </tr>
                        @endif
                        <tr>
                            <td>Date of Creation</td>
                            <td>{{$penalty->created_at->toDayDateTimeString()}}</td>
                        </tr>
                        @if ($penalty->status == 'pending' && Auth::user()->category == 'police')
                        <td></td>
                        <td>
                            <form method="post" action="/penalty_clear">
                                {{csrf_field()}}
                                <input type="hidden" value="{{$penalty->id}}" name="penalty_id"/>
                                <button type="submit" class="btn btn-sm btn-outline-primary">Clear</button>
                            </form>
                        </td>
                        <td></td>
                        <td>
                            <form method="post" action="/penalty_reject">
                                {{csrf_field()}}
                                <input type="hidden" value="{{$penalty->id}}" name="penalty_id"/>
                                <button type="submit" class="btn btn-sm btn-outline-danger">Reject</button>
                            </form>
                        </td>
                        @endif
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
          
        <div class="col-md-12">
            <div class="card border-transparent">
                <div class="card-header">
                    <h3 class="card-title">Other penalties for {{$penalty->locationFinder->bus->number_plate}}</h3>
                </div>
                <div class="card-body">
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
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @foreach ($other_penalties as $openalty)
              <tr>
                <td>{{$openalty->locationFinder->bus->bus_company->company_name}}</td>
                <td>{{$openalty->locationFinder->bus->number_plate}}</td>
                @if ( $openalty->status != 'Provisional')
                <td>{{$openalty->assigner->user->name}}</td>
                <td>{{$openalty->assigned_date->toDayDateTimeString()}}</td>
                @else
                <td></td>
                <td></td>
                @endif
                
                <td>{{$openalty->place}}</td>
                <td>{{$openalty->speed}}</td>
                <td>{{$openalty->status}}</td>
                <td>@if ($openalty->status != 'pending' && $openalty->status != 'provisional')
                  {{$penalty->clearer->user->name}}
                  @endif
                </td>
                <td>
                  @if ($openalty->status != 'pending' && $openalty->status != 'provisional')
                  {{$penalty->cleared_date->toDayDateTimeString()}}
                  @endif
                </td>
                <td>{{$openalty->created_at->toDayDateTimeString()}}</td>
                <td>
                  @if ($openalty->status == 'pending' && Auth::user()->category == 'police')
                  <form method="post" action="/penalty_clear">
                    {{csrf_field()}}
                    <input type="hidden" value="{{$openalty->id}}" name="penalty_id"/>
                    <button type="submit" class="btn btn-sm btn-outline-primary">Clear</button>
                    </form>
                    
                  @endif
                </td>
                <td>
                @if ($openalty->status != 'cleared' && Auth::user()->category == 'police')
                  <form method="post" action="/penalty_reject">
                    {{csrf_field()}}
                    <input type="hidden" value="{{$openalty->id}}" name="penalty_id"/>
                    <button type="submit" class="btn btn-sm btn-outline-danger">Reject</button>
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
                    <th>Place</th>
                    <th>Speed</th>
                    <th>Status</th>
                    <th>Cleared By</th>
                    <th>Date of Clearance</th>
                    <th>Date of Creation</th>
                    <th></th>
                    <th></th>
                </tr>
            </tfoot>
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
<script src="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('#example').DataTable();
});
</script>