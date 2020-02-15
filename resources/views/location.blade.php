<!-- manage location settings -->
<div class="content" id="location-view">
	<form >
		<fieldset>
			<legend>Location information</legend>
			<label>Location Name:</label>
			<input type="text" value="{{$location->name}}"/>
			<label>Location ID:</label>
			<input type="text" id="location-id" class="uneditable" readonly value="{{$location->id}}" size="4"/><br>
		</fieldset>
	</form>
	<form id="unassign-employee">
		<fieldset>
			<legend>Assigned Employees:</legend>
			@if(count($location->employees))
			<label>Select employee to remove:</label><br>
			<select size="5" name="assigned_employee" id="assigned-employee">
				@foreach ($location->employees as $employee) {
				<option value="{{$employee->id}}">{{$employee->last_name .','. $employee->first_name .' (' . $employee->id.')' }}</option>
				@endforeach
			</select><br>
			<input type="submit" value="Remove" />
			@else
				<p>No employees assigned</p>
			@endif
		</fieldset>
	</form>
	<form id="assign-employee">
		<fieldset>
			<legend>Assign new employee:</legend>
			@if(count($employees))
			<select name = "assignable_employee" id="assignable-employee">
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
