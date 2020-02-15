@isset($timesheets)
@forelse($timesheets as $timesheet){
<table>
	<caption>{{$timesheet.key}}</caption>
    <tr><th>Visit ID</th><th>Date</th><th>Time In</th><th>Time Out</th><th>Total</th><th>Timestamp</th></tr>
        @foreach($timesheet.visits as $visit)
            <tr><td class='visitid'>{{$visit.id}}</td><td >{{$visit.date}}</td><td>{{$visit.time_in}}</td><td>{{$visit.time_out}}</td><td>{{$visit.total}}</td><td>{{$visit.created_at}}</td></tr>
        @endforeach
</table>
@empty
<p>"No results for the terms requested"</p>
@endforelse
@endisset
