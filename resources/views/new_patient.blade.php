<div class="content" id="add-new-patient">
	<form id="add-new-patient-form" method="POST">
		{{ csrf_field() }}
		<fieldset>
			<legend>New patient information</legend>
			<label>Name:</label>
			<input type="text" id="patient-name" name="first_name" required/><br>
			<label>Last name:</label>
			<input type="text" id="patient-lastname" name="last_name" required/>
			<!--<label>Initial:</label>
			<input type="text" id="newPtInitial"/>--><br>	
			<input id="add-patient" type="submit" value="Save" name="add_new_patient">
			<input id="cancel-add-patient" type="button" value="Cancel" onclick="location.reload()"/>
		</fieldset>
	</form>
</div>