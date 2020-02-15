<!-- location search -->
<div class="options" id="locations">
	<form id="search-location" method="GET">
	{{ csrf_field() }}
    <fieldset class="optionsForms" id="locationOptions">
        <legend>Search locations:</legend><br/>
        <select class="locationSelection" name="location" id="select-location" >
        	<option value="default" selected>Select location</option>
        	@foreach(App\Location::orderBy('name')->get() as $location)
            <option id="{{ $location->id }}" value="{{ $location->id }}">{{ $location->name . '(' . $location->id . ')' }}</option>
        	@endforeach
        </select>
    </fieldset>
</div>