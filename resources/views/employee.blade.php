<div class="content" id="employee-view">
	<form id="employee-profile-form" method="PUT">
	{{ csrf_field() }}
		<fieldset>
			<legend>Employee information</legend>
			<label>Employee ID:</label>
			<input type="text" id="employee-id" name="id" class="uneditable" readonly size="4" value="{{ $employee->id }}"/><br>
			<label>Name:</label>
			<input type="text" class="employeeinfo" id="employee-name" name="first_name" value="{{ $employee->first_name }}"/>
			<label>Initial:</label>
			<input type="text" class="employeeinfo" id="employee-initial" size="1" value="{{ $employee->initial }}"/><br>
			<label>Last name:</label>
			<input type="text" class="employeeinfo" id="employee-lastname" name="last_name" value="{{ $employee->last_name }}"/><br>
			<label>Position:</label>
			<select name="type" id="employee-type" class="employeeinfo">
				<option id="0">Select type</option>
				<option id="1" value="aide" @if($employee->type === "aide") selected @endif >HHA</option>
				<option id="2" value="office" @if($employee->type === "office") selected @endif >Office</option>
				<option id="3" value="super" @if($employee->type === "super") selected @endif >Supervisor</option>
			</select><br>
			<input type="checkbox" name="is_active" @if($employee->is_active) checked @endif readonly >Acitve</input>
			<br>
			<input type="checkbox" name="is_blocked" @if($employee->is_blocked) checked @endif readonly >Blocked</input>
			<br>
			<label>Upload restriction date:</label>
			<input type="text" name="urdate" id="employee-ur-date" value="{{$employee->cutoff_date}}" />				
			<br><hr>
			<p>User login information:</p>
			<label>Username:</label>
			<input type="text" class="employeeinfo" name="username" id="username" value="@if(isset($user)){{ $user->username }}@endif"><br>
			<label>Password:</label>
			<input type="text" class="employeeinfo" name="password" id="password" value="@if(isset($user)){{ $user->password }}@endif">
			<hr>
			<input id="edit-employee-profile" type="button" value="Edit" name="editemployee" />
			<input id="save-employee-profile" type="submit" value="Save" name="savechanges" >
			<input id="cancel-edit" type="reset" value="Cancel" />
		</fieldset>
	</form>
	<form id="unassign-patient">
	{{ csrf_field() }}
		<fieldset>
			<legend>Assigned patients:</legend>
			@if(count($assigned_patients))
				<label>Select patient to remove:</label><br>
				<select size="5" name="assigned-pt" id="assigned-patients">
				@foreach ($assigned_patients as $patient)
					<option value='{{ $patient->id }}' >{{ $patient->last_name }}, {{ $patient->first_name }} ({{ $patient->id }})</option>
				@endforeach
				</select><br>
			<input type="submit" value="Remove" @if(!isset($employee->patients)) disabled @endif/>
			@else
				<p>No patients assigned</p>
			@endif
		</fieldset>
	</form>
	<form id="assign-patient">
	{{ csrf_field() }}
		<fieldset>
			<legend>Assign new patient:</legend>
			@if(count($patients))
				<select name = "patient-id" id="assignable-patients" >
					@foreach($patients as $patient)
						<option value='{{$patient->id}}' >{{$patient->last_name}}, {{$patient->first_name}} ({{$patient->id}}) </option>
					@endforeach
				</select>
			<input type="submit" value="Assign" name="assignpt" id="assignpatient" @if(!isset($patients)) disabled @endif />
			@else
				<p>No patients found :(</p>
			@endif
		</fieldset>
	</form>
	<form id="unassign-location">
	{{ csrf_field() }}
		<fieldset >
			<legend>Assigned locations:</legend>
			@if(count($assigned_locations))
				<label>Select location to remove:</label><br>
				<select size="5" name="assigned_locations" id="assigned-locations">
				@foreach ($assigned_locations as $location)
					<option value='{{ $location->id }}'>{{ $location->name }} ({{ $location->id }})<option/>
				@endforeach
				</select><br>
				<input type="submit" value="Remove" @if(!isset($assigned_locations)) disabled @endif/>
			@else
				<p>No locations assigned</p>
			@endif
		</fieldset>
	</form>
	<form id="assign-location">
	{{ csrf_field() }}
		<fieldset>
			<legend>Assign new location:</legend>
			@if(count($locations))
				<select name="assignable_locations" id="assignable-locations" >
				@foreach ($locations as $location)
					<option value='{{$location->id}}' >{{$location->name}} ({{$location->id}})</option>
				</select>
				<input type="submit" value="Assign" @if(!isset($locations)) disabled @endif/>	@endforeach
			@else
				<p>No locations found :(</p>
			@endif
		</fieldset>
	</form>
</div>