<!-- schedule options -->
<div class="options" id="add-schedule">
    <form>
        <fieldset class="optionsForms" id="schedule-options">
            <legend>Select patient:</legend>
            <label> Search by Id:</label>
            <input type="text" id="search-add-sched-patient-by-id" size="4"/>
            <select class="patientSelection" name="patient" id="add-sched-patient" >
                <option value="default" selected>Select patient:</option>
                @foreach(App\Patient::orderBy('last_name')->get() as $patient)
                    <option id="{{ $patient->id }}" value="{{ $patient->id }}">{{ $patient->last_name .','.$patient->first_name .' ('.$patient->id.')' }}
                    </option>
                @endforeach
            </select>
            <label>Schedule month:</label>
            <select class="monthSelection" name="month" id="sched-month" >
                <option value="default" selected>Select month:</option>
                <option value="0">January</option>
                <option value="1" >February</option>
                <option value="2">March</option>
                <option value="3">April</option>
                <option value="4">May</option>
                <option value="5">June</option>
                <option value="6">July</option>
                <option value="7">August</option>
                <option value="8">September</option>
                <option value="9">October</option>
                <option value="10">November</option>
                <option value="11">December</option>
            </select>               
            <select class="yearSelection" name="year" id="sched-year" >
                <option value="default" selected>Select year:</option>
                <?php
                $y = getDate()['year']-1;
                $max = $y + 3;
                    for(; $y < $max ;$y++){
                        echo "<option value=" . $y . ">" . $y . "</option>"; 
                    }
                ?>
            </select>
            <input type="button" value="View" onclick="createCalendar()"/><br/>
        </fieldset>
    </form>
    <div id='calendar'>
        
    </div>
</div>