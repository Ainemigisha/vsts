@include('layouts.header')
@include('layouts.nav_bar')
@include('layouts.side_bar')

<div class="content-wrapper pl-2 pt-2">

    <div class="container-fluid ">

        <table id="example" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>Number Plate</th>
                    <th>Company</th>
                    <th>Average Speed</th>
                    <th>Total Penalties</th>
                </tr>
            </thead>
            <tbody>
                @foreach($buses as $bus)
                    <tr>
                        <td><a href="/bus_details/{{$bus->id}}">{{$bus->number_plate}}</a></td><td>{{$bus->company_name}}</td><td>{{$bus->avg_speed}}</td><td>{{$bus->total_penalties}}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th>Number Plate</th>
                    <th>Company</th>
                    <th>Average Speed</th>
                    <th>Total Penalties</th>
            </tfoot>
        </table>

    </div>

</div>

@include('layouts.footer')
<script src="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('#example').DataTable();
});
</script>