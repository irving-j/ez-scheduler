@if(Session::has('message'))
    <p class="message" >{{ Session::get('message') }}</p>
@endif
</div>
@isset($timesheets)
@forelse($timesheets as $timesheet)
    <table>
    <caption>{{ $timesheet->patient }}</caption>
    <tr><th>Visit ID</th><th>Date</th><th>Time In</th><th>Time Out</th><th>Total</th><th>Time added:</th><th>Time updated:</th></tr>
    @foreach($timesheet->visits as $visit)
        <tr><td class='visitid'>{{ $visit->id }}</td><td >{{ $visit->date }}</td><td>{{$visit->time_in }}</td><td>{{$visit->time_out}} </td><td> {{$visit->total}} </td><td>{{$visit->created_at}} </td><td>{{$visit->updated_at}} </td></tr>
    @endforeach
    </table>
@empty
<p>No results found</p>
@endforelse
@endisset