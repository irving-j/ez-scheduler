<!-- manage patient settings -->
<div class="content" id="patient-view">
	<form >
		<fieldset>
			<legend>Patient information</legend>
			<label>Patient ID:</label>
			<input type="text" class="uneditable" id="patient-id" value="{{$patient->id}}" size="4" readonly /><br>
			<label>Name:</label>
			<input type="text" class="patient-info" name="patient_name" value="{{$patient->first_name}}"/><br>
			<label>Last name:</label>
			<input type="text" class="patient-info" name="patient_last_name" value="{{$patient->last_name}}"/><br>
			<input type="button" value="Edit" id="editpatient" onclick="enablepatientedit(true)"/>
			<input type="submit" value="Save" />
			<input id="canceleditpatient" type="reset" value="Cancel" />
		</fieldset>
	</form>
	<form name="remove_aide" id="unassign-aide">
		<fieldset>
			<legend>Assigned HHAs:</legend>
			@if(count($assigned_employees))
			<label>Select aide to remove:</label><br>
			<select size="5" name="assigned_hha" id="assigned-aide">
				@foreach ($assigned_employees as $employee)
				<option value="{{$employee->id}}">{{$employee->last_name}},{{$employee->first_name}}({{$employee->id}})</option>
				@endforeach
			</select><br>
			<input type="submit" value="Remove" />
			@else
				<p>No employees assigned</p>
			@endif
		</fieldset>
	</form>
	<form name="assign-aide" id="assign-aide">
		<fieldset>
			<legend>Assign new HHA:</legend>
			@if(isset($employees))
			<select name = "assignable_employee" id="assignable-aide">
				<option value="default" selected>Select employee</option>
	        	@foreach($employees as $employee)
	            <option value="{{ $employee->id }}">{{ $employee->last_name .','.$employee->first_name .' ('.$employee->id.')' }}</option>
	        	@endforeach
			</select>
			<input type="submit" value="Assign" />
			@else
				<p>No employees found</p> 
			@endif
		</fieldset>
	</form>
</div>
