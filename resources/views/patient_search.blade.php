<!-- patient search -->
<div class="options" id="patients">
	<form id="search-patient" method="GET">
	{{ csrf_field() }}
	    <fieldset class="options-forms" id="patient-options">
	        <legend>Search for a patient:</legend><br/>
	        <label> Select a patient:</label>
	        <select class="patient-selection" name="patient" id="select-patient" >
	            <option value="default" selected>Select patient</option>
	            @foreach(App\Patient::orderBy('last_name')->get() as $patient)
	            <option id="{{ $patient->id }}" value="{{ $patient->id }}">{{ $patient->last_name .','.$patient->first_name .' ('.$patient->id.')' }}</option>
	        	@endforeach
	        </select>
	         <label> Search by Id:</label>
	        <input type="text" id="search-patient-id" size="4"/>
	        <input type="submit" value="Search"/>
	    </fieldset>
	</form>
</div>