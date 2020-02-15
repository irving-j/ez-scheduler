@isset($schedules)
    @if (count($schedules) > 0)
    	<p>Enter hours for {{ $patient->first_name . ' ' . $patient->last_name}}:</p>
        @foreach($schedules as $schedule)
        <div class="time-card" id="timecard-{{$schedule->id}}">
            <form class="time-card" data-timecard-id="{{$schedule->id}}">
                <label class="time-card" ><span class="time-card" >Date:</span><input type="text" class="visit-date" name="date" value="{{$schedule->date->format('D M d,Y')}}" readonly /></label>
                <label class="time-card" ><span class="time-card" >Time In:</span><input type="time" class="time-in" name="time_in" required/></label>
                <label class="time-card" ><span class="time-card" >Time Out:</span><input type="time" class="time-out" name="time_out" required/></label>
                <label class="time-card" ><span class="time-card" >Total:</span><input type="text" class="visit-total" name="total" required/></label>
                <input type="text" value="{{$patient->id}}" name="patient_id" hidden/>
                <input type="submit" value="Submit" />
            </form>
            @if(Session::has('message'))
            <p class="message" >{{ Session::get('message') }}</p>
            @endif
        </div>
        @endforeach
    @else
        <p> No scheduled visits found for {{ $patient->first_name . ' ' . $patient->last_name}}! </p>
    @endif
@endisset
