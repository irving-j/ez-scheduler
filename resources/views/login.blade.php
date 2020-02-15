
<!DOCTYPE html>
<html>
	<head>
		<title>ETMSystem - Log In</title>
		<meta name="description" content="Timesheet Management System"></meta>
		<meta name="author" content="ist-82" ></meta>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel = "stylesheet" type="text/css" href ="css/main.css">
	</head>
	<body>
		<div id="container">	
			<div id="loginDiv" >
				<form action="{{ route('login') }}" method="POST">
					{{ csrf_field() }}
					<fieldset >
						<legend>Login</legend>
						<label >UserName:</label>
						<input type="text" name="username" maxlength="50" required/>
						<label >Password:</label>
						<input type="password" name="password" maxlength="50" required/>
						<input type="Submit" value="Log in" />
					</fieldset>
				</form>
				@if($errors->any())
					<ul>
					@foreach($errors->all() as $error)
            			<li class="message" >{{ $error }}</li>
            		@endforeach
            		</ul>
        		@endif
			</div>
			<div style="min-width:300px;text-align:center"><p>Click on this <a href="https://www.youtube.com/watch?v=pZ0fOYzkBYg">link</a> to watch a quick tutorial on how to use this tool.</p>
            </div>
			<div class="copyrightDiv">
				<p>&copy; 2014 - <span id="currentyear" ><script >document.getElementById("currentyear").innerHTML= new Date().getFullYear();</script></span> All rights reserved. </p>
			</div>
		</div>
	</body>
</html>