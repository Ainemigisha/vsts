@include('layouts.header')
@include('layouts.nav_bar')
@include('layouts.side_bar')

<div class="content-wrapper">

    <div class="container-fluid ml-2 ">

    <div class="pt-4">
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
                <td>{{$penalty->assigner->user->name}}</td>
                <td>{{$penalty->assigned_date->toDayDateTimeString()}}</td>
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
                    <th>Place</th>
                    <th>Speed</th>
                    <th>Status</th>
                    <th>Cleared By</th>
                    <th>Date of Clearance</th>
                    <th>Date of Creation</th>
                    <th></th>
                </tr>
            </tfoot>
      </table>
    </div>

    </div>

</div>

@include('layouts.footer')
<script type="text/javascript">
$(document).ready(function() {
    $('#example').DataTable();
});
</script>