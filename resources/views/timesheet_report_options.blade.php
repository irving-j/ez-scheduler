<!--get totals-->
<div class="options" id="totals">
    <form id="timesheet-report">
        <fieldset class="optionsForms" >
            <legend>Select employee(s) and date options:</legend>
            <label style="display:inline-block;width:200px" id="select-emp-lbl">Employee options:</label>
            <label>Week ending on:</label>
            <br/>
            <select class="employeeSelection" name="employee_option" >
                <option id="all" value="all" >All</option>
                <option id="active" value="active" selected>Show only active</option>
            </select>
            <input type="text" name="end_date" id="week-2-end-date" required />
            <input type="submit" value="Ok" / >
        </fieldset>
    </form>
</div>