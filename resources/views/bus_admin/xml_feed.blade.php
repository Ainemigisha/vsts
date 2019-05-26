<markers>

@foreach($locations as $location)
	<marker id="{{$location->id}}" name="Speed = {{$location->speed}}Km/hr" address="makerere" lat="{{$location->latitude}}" lng="{{$location->longitude}}" type="restaurant"/>
@endforeach

</markers>