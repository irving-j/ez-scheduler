<!-- get timesheets -->     
<div class="options" id="timesheets">
    <form id="view-timesheets">
        <fieldset class="optionsForms">
            <legend>Select employee(s) and date options:</legend>
            <label style="margin-right:10px;display:inline-block;width:200px" id="selectptlbl">Select employee:</label>
            <label style="margin-right:10px;display:inline-block;width:100px">Start date: </label><label style="display:inline-block;width:100px">End date:</label><br/>
            <select class="employee-selection" id="ts-select-employee" name="employee_id">
                <option value="default" selected>Select employee</option>
                @foreach(App\models\Employee::orderBy('last_name')->get() as $employee)
                <option id="{{ $employee->id }}" value="{{ $employee->id }}">{{ $employee->last_name .','.$employee->first_name .' ('.$employee->id.')' }}</option>
                @endforeach
            </select>
            <input id="start-date" type="text" style="margin-right:10px;width:100px" name="start_date" required/>
            <input id="end-date" type="text" style="margin-right:10px;width:100px;" name="end_date" required/>
            <input type="submit" value="Ok"/ >
        </fieldset>
    </form>
</div>