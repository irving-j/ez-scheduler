<div class="options" id="timesheet-edit-options">
	<form class="options-forms" id="visit-edit-options-form">
	    <fieldset class="options-forms" >
	        <legend>Choose a patient</legend>
	        <select class="patient-selection" name="patient_id" id="visit-edit-patient-select" required>
	            <option value="default" selected>Select patient</option>
	            @foreach(App\Patient::orderBy('last_name')->get() as $patient)
	            <option id="{{ $patient->id }}" value="{{ $patient->id }}">{{ $patient->last_name .','.$patient->first_name .' ('.$patient->id.')' }}</option>
	            @endforeach
	        </select>
	        <label class="" ><input type="text" class="date-picker" name="start_date" required/></label>
	        <label class="" ><input type="text" class="date-picker" name="end_date" required/></label>
	        <input type="submit" value="Search"/>
	    </fieldset>
    </form>
</div>