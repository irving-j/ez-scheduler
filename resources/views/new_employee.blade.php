<div class="content" >
	<form id="new-employee-form" method="POST">
	{{ csrf_field() }}
	<fieldset>
		<legend>New employee information</legend>
		<label>Name:</label>
		<input type="text" name="first_name" />
		<label>Initial:</label>
		<input type="text" name="initial" size="1"/>
		<br>
		<label>Last name:</label>
		<input type="text" name="last_name" />
		<br>
		<br>
		<label>Position:</label>
		<select name="type">
			<option id="0" value="default" >Select type</option>
			<option id="1" value="aide" >HHA</option>
			<option id="2" value="office" >Office</option>
			<option id="3" value="super" >Supervisor</option>
		</select><br>				
		<br><hr>
		<p>User login information:</p>
		<label>Username:</label>
		<input type="text" name="username" ><br>
		<label>Password:</label>
		<input type="text" name="password"  ><br>
		<input id="add-employee" type="submit" value="Save" />
		<input id="cancel-add-employee" type="button" value="Cancel" onclick="location.reload()"/>
	</fieldset>
	</form>
</div>