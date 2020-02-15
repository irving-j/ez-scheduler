@isset($timecards)
    @if (count($timecards) > 0)
    	<p>{{ $patient->first_name . ' ' . $patient->last_name . '('. $patient->id .')'}}</p>
        @foreach($timecards as $timecard)
            <form class="time-card" id="time-card-{{$timecard->id}}" >
                <label class="time-card" ><span class="time-card" >Date:</span><input type="text" class="visit-date" name="date" value="{{date('D M d,Y', strtotime($timecard->date))}}" readonly /></label>
                <label class="time-card" ><span class="time-card" >Time In:</span><input type="time" class="time-in" name="time_in" value="{{$timecard->time_in}}" required/></label>
                <label class="time-card" ><span class="time-card" >Time Out:</span><input type="time" class="time-out" name="time_out" value="{{$timecard->time_out}}" required/></label>
                <label class="time-card" ><span class="time-card" >Total:</span><input type="text" class="visit-total" name="total" required/></label>
                <input type="text" value="{{$patient->id}}" name="patient_id" hidden/>
                <input type="button" class="save-time-card" value="Save" data-timecard-id="{{$timecard->id}}"/>
                <input type="button" class="delete-time-card" value="delete" data-timecard-id="{{$timecard->id}}"/>
            </form>
        @endforeach
    @else
        <p> No timesheets found for {{ $patient->first_name . ' ' . $patient->last_name}}! </p>
    @endif
    @if(Session::has('message'))
        <p class="message" >{{ Session::get('message') }}</p>
    @endif
@endisset
