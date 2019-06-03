<markers>

@foreach($locations as $location)
	<marker id="{{$location->id}}" speed="{{$location->speed}}" bus_name="{{$location->location_finder->bus->number_plate}}: Speed = {{$location->speed}}Km/hr" address="makerere" lat="{{$location->latitude}}" lng="{{$location->longitude}}" type="bus" flag="{{$location->location_finder->flag}}" company="{{$location->speed}}" name="{{$location->location_finder->bus->bus_company->company_name}}"/>
@endforeach

</markers>