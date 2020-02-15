<!-- set ur date -->
<div class="options" id="set-ur-date">
	@isset($ur_date)
	<p>Currently set to: {{$ur_date}}</p>
	@endisset
	<form id="update-ur-date">
	    <fieldset class="optionsForms" >
	        <legend>Select timesheet upload restriction date:</legend>
	        <input class="has-date-picker" type="text" name="ur_date" id="ur-date" required/>
	        <input type="submit" value="Save"/ >
	    </fieldset>
	</form>
</div>