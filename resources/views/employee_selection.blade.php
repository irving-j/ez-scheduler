<select class="employee-selection" id="select-employee">
	<option value="default" selected>Select employee</option>
	@foreach(App\Employee::orderBy('last_name')->get() as $employee)
    <option id="{{ $employee->id }}" value="{{ $employee->id }}">{{ $employee->last_name .','.$employee->first_name .' ('.$employee->id.')' }}</option>
	@endforeach
</select>