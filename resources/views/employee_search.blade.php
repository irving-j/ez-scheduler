<!-- employee search -->
<div class="options" id="employees">
	<form id='search-employee' method='GET'>
	{{ csrf_field() }}
	    <fieldset class="options-forms" id="employee-options">
	        <legend>Search for an employee:</legend><br/>
	        <label>Select employee:</label>
	        @include('employee_selection')<label> - or - </label>
	        <label> Search by Id:</label>
	        <input type="text" id="emp-id" size="4"/>
	        <input type="Submit" value="Search"/>
	    </fieldset>
    </form>
</div>