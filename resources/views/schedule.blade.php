<div class='sched-div'>
	<table class='schedule-table'>
		<caption id='key'>{{client}}</caption>
		<tr><th>Sched ID</th><th>Patient Id</th><th>Max Hours</th><th>Date</th><th colspan='2'>Options</th></tr>
		 	@foreach(allschedules as schedule)
     		<tr><td class='schedule-id'>{{$schedule.id}}</td><td>{{$schedule.patient.id}}</td><td> 
     		{{$schedule.max_hours}}</td><td>{{$schedule.date}}</td><td>
     		<button class='editschedule' value="{{schedule.id}}">Edit</button>
     		<button value="{{$schedule.id}}" onclick='deleteSchedule(this)'>Delete</button></td></tr>
     		@endfor
	</table>
</div>
 
<td colspan="6">
	<form name="edit_schedule">
		<input type="text" value="{{$schedule.id}}" class='schedid' />
		<label>Enter maximum hours: </label><input type='text' size='5' maxlength='5' id='newmax'/>";
		<input type="button" onclick="location.reload()">Cancel</input>
		<input type="submit" >Submit</>
	</form>
</td>