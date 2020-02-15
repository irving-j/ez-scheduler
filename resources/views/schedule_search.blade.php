<!-- view schedules -->
<div class="options" id="view-schedule">
	<form id="search-schedule" method="GET">
	{{ csrf_field() }}
    <fieldset class="optionsForms" id="schedule-options">
        <legend>Select patient:</legend>
        <label> Search by Id:</label>
        <input type="text" id="search-sched-patient-by-id" size="4"/>
        <select class="patientSelection" name="patient" id="schedule-patient" >
            <option value="default" selected>Select patient:</option>
            @foreach(App\Patient::orderBy('last_name')->get() as $patient)
	            <option id="{{ $patient->id }}" value="{{ $patient->id }}">{{ $patient->last_name .','.$patient->first_name .' ('.$patient->id.')' }}</option>
	        @endforeach
        </select>
    </fieldset>
    </form>
</div>