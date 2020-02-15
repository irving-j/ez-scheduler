
application/x-httpd-php superaccount.php
HTML document text

<!DOCTYPE html>
<html>
	<head>
		<title>EEMS beta - My Account</title>
		<meta charset="utf-8">
		<meta name="keywords" content="essy employee tracking system,essy employee tracking,essy time sheet"></meta>
		<meta name="description" content="Essy Nursing Employee Tracking and Time Management System"></meta>
		<meta name="author" content="Irving Santiago" ></meta>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel = "stylesheet" type="text/css" href ="css/main.css">
		<link rel = "stylesheet" type="text/css" href ="css/jquery-ui.css">
		<script src="jquery/jquery-2.1.1.min.js"></script>
		<script src="jquery/jquery-ui.js"></script>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
		<script src="scripts/javascript/essy-js.js"></script>
		<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
		<script src="//code.jquery.com/jquery-1.10.2.js"></script>
		<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				$("div#totals-button").click(function(){
					$("div.options").hide();
					$("div.content").hide();
					$("div#totals").show();
				});
				$("p#view-timesheet").click(function (){
					$("div.options").hide();
					$("div.content").hide();
					$("div#timesheets").show();
				});
				$("p#search-ts-btn").click(function (){
					$("div.options").hide();
					$("div.content").hide();
					$("div#timesheetsearch").show();
				});
				$("p#ur-date-btn").click(function (){
					$("div.options").hide();
					$("div.content").hide();
					$("div#set-ur-date").show();
					var url = "scripts/urdate.txt";
					$.get(url, function(data, status){
						var date = data.split("-");

						$( "#ur-date" ).datepicker({ dateFormat: 'mm-dd-yy' });
						$( "#ur-date" ).datepicker("setDate", date[1] + "-" + date[2] + "-" + date[0]);
					});
				});
				$("#search-emp-btn").click(function (){
					$("div.options").hide();
					$("div.content").hide();
					$("div#employees").show();
				});
				$("#add-emp-btn").click(function (){
					$("div.options").hide();
					$("div.content").hide();
					$("div#add-new-employee").show();
				});
				$("#search-pt-btn").click(function (){
					$("div.options").hide();
					$("div.content").hide();
					$("div#patients").show();
				});
				$("#add-pt-btn").click(function (){
					$("div.options").hide();
					$("div.content").hide();
					$("div#add-new-patient").show();
				});
				$("#schedule-btn").click(function (){
					$("div.options").hide();
					$("div.content").hide();
					$("div#view-schedule").show();
					getSchedule();
				})
				$("#add-sch-btn").click(function (){
					$("div.options").hide();
					$("div.content").hide();
					$("div#add-schedule").show();
				})
                $("#sched-report-btn").click(function (){
                    $("div.options").hide();
                    $("div.content").hide();
                    $("div#schedule-report").show();
                })
				$("#add-loc-btn").click(function (){
					$("div.options").hide();
					$("div.content").hide();
					$("div#add-location").show();
				});
				$("#search-locs-btn").click(function (){
					$("div.options").hide();
					$("div.content").hide();
					$("div#locations").show();
				});
				$("div#notifications-button").click(function (){
					$("div.options").hide();
					$("div#notifications").show();
				});
				$("#show-employee").click(function (){
					var employeeid = $("#select-employee").children(":selected").attr("id");
					if(!isNaN(employeeid)){
						$("#select-employee").css("border","1px solid rgb(169, 169, 169)");
						$("#select-employee")
						$("#employee-view").show();
						getEmployee(employeeid);
					}
					else{
						$("#select-employee").css("border","1px solid red");
					}
				});
				$("#show-patient").click(function (){
					var patientId = $("#select-patient").children(":selected").attr("id");
					$("#patient-view").show();
					getPatient(patientId);
				});
				$("#show-location").click(function (){
					var locationId = $("#select-location").children(":selected").attr("id");
					$("#location-view").show();
					getLocation(locationId);
				});
				$("#search-employee-by-id").change(function(){
					if($('#select-employee option[value='+ this.value +']').length > 0){
						$("#select-employee").val(this.value);
						$("#main-content").empty();
						$("#main-content").hide();
						getEmployee(this.value);
						this.value="";
					}else{
						$("#employee-view").hide();
						$("#main-content").show();
						$("#main-content").html("No match found.");
						$("#select-employee").val("default");
					}
				});
				$("#search-add-sched-patient-by-id").change(function(){
					if($('#add-sched-patient option[value='+ this.value +']').length > 0){
						$("#add-sched-patient").val(this.value);
						this.value="";
					}
				});
				$("#search-sched-patient-by-id").change(function(){
					if($('#sched-patient option[value='+ this.value +']').length > 0){
						$("#sched-patient").val(this.value);
						getSchedule();
						this.value="";
					}
				});
				$("#search-patient-by-id").change(function(){
					if($('#select-patient option[value='+ this.value +']').length > 0){
						$("#select-patient").val(this.value);
						$("#main-content").empty();
						$("#main-content").hide();
						getPatient(this.value);
						this.value="";
					}else{
						$("#patient-view").hide();
						$("#main-content").show();
						$("#main-content").html("No match found.");
						$("#select-patient").val("default");
					}
				});
				$("#sched-patient").change(function(){
					if($('#select-patient option[value='+ this.value +']').length > 0){
						$(this).val(this.value);
						$("#main-content").empty();
						$("#main-content").hide();
						getSchedule();
					}else{
						$("#patient-view").hide();
						$("#main-content").show();
						$("#main-content").html("No schedules found.");
					}
				});
				$(function() {
                    applyAccountSettings();
					getEmployees(true);
					getAllPatients();
					getAllLocations();
				});
				$(function() {
					$( "#week2enddate" ).datepicker({ dateFormat: 'mm-dd-yy' });
					$( "#week2enddate" ).datepicker("setDate", new Date());
					$( "#startdate" ).datepicker({ dateFormat: 'mm-dd-yy' });
					$( "#startdate" ).datepicker("setDate", new Date());
					$( "#enddate" ).datepicker({ dateFormat: 'mm-dd-yy' });
					$( "#enddate" ).datepicker("setDate", new Date());
					$( "#employeeurdate" ).datepicker({ dateFormat: 'yy-mm-dd' });
					$( "#employeeurdate" ).datepicker("setDate", new Date());
					$( "#employeeurdate" ).datepicker("disable");
					$( "#schedStartDate" ).datepicker({ dateFormat: 'mm-dd-yy' });
					$( "#schedStartDate" ).datepicker("setDate", new Date());
					$( "#schedEndDate" ).datepicker({ dateFormat: 'mm-dd-yy' });
					$( "#schedEndDate" ).datepicker("setDate", new Date());
				});	
				$("#cancel-edit").click(function(){
					enableedit(false);
					var employeeid = $("#employeeId").val();
					getEmployee(employeeid);
				});
				$("#cancel-edit-patient").click(function(){
					enablePatientEdit(false);
					var patientid = $("#patientId").val();
					getPatient(patientid);
				});
				$("#cancel-edit-location").click(function(){
					enableLocationEdit(false);
					var locationid = $("#locationId").val();
					getLocation(locationid);
				});
				$(".messages-button").click(function (){
					$("#messages").hide();
					$("#message-viewer").hide();
					$("#main-content").empty();
					$("div.options").hide();
					$("div.content").hide();
					$("div#message-options").show();	
					getMessages();
				});
				$("#compose-btn").click(function(){
					$("#main-content").empty();
					$("#main-content").hide();
					$("#message-viewer").hide();
					$("#messages").show();
					$("#msg-recipients").empty();
					$("#new-msg-subject").val("");
					$("#new-msg-body").val("");
					$("#messages").css("height","600px");
					getRecipients(true);
				});
				$("#slct-recipients").change(function() {
    				addRecipients();    				
				});
				$("#msg-body").click(function(){
					$('#msg-body').prop("selectionStart");
				});
				$("#delete-open").click(function(){
					$("#message-viewer").hide();
					deleteOpenMessage();
				});
                $("#sched-report").click(function(event){
                    var reportType = $("input[name=report-option]:checked").val();
                    $.get("scripts/getschedulereport.php?type=" + reportType,
                        function(response){
                            $("#maincontent").html('<label>Due soon: </label><div class="report-color-code" id="duesoondiv"></div> <label>Past due: </label><div class="report-color-code" id="pastduediv"></div>');
                            $("#maincontent").append('<table>');
                            var data = response["schedules"];
                            $("#maincontent").append('<tr><th>Schedule Id</th><th>Patient Id</th><th>Patient Name</th><th>Scheduled Hours</th><th>Date</th></tr>');
                            for(var i = 0; i < data.length;i++){
                                $("#maincontent").append('<tr>');
                                $("#maincontent").append('<td>' + data[i].scheduleId + '</td><td>' + data[i].patientId + '</td><td>'+ data[i].name + '</td><td>' + data[i].maxHours + '</td>');
                                var d = new Date(data[i].date);
                                var now = new Date();
                                var week = new Date();
                                week.setDate(now.getDate() + 7);
                                if(d > now && d < week)
                                    $("#maincontent").append('<td class="duesoontd">'+ data[i].date + '</td>');
                                else if(now > d)
                                    $("#maincontent").append('<td class="pastduetd">'+ data[i].date + '</td>');
                                else
                                    $("#maincontent").append('<td >'+ data[i].date + '</td>');
                                $("#maincontent").append('</tr>');
                            }
                            $("#maincontent").append('</table>');
                            $("#maincontent").show();
                        },'json');
                });
			});
			$(document).on("click","a.msg-link",function(){
				$("#main-content").empty();
				$("#main-content").hide();
			});
			$(document).on("click","input#select-all",function(){
					$("input:checkbox").prop("checked", $("input:checkbox").prop("checked"));		
			});
			$(document).on("click","button#delete-msg",function(){
					deleteMessage();	
			});
			$(document).on("click","button.close" ,function(){
				$("button.edit-schedule").prop("disabled",false);
				$(this).parent().parent().remove();
			});
			$(document).on("click","button.edit-schedule" , function(){
				$("button.edit-schedule").prop("disabled",true);
			});
			
            function printContent(elem, heading)
            {
                var mywindow = window.open('', 'PRINT', 'height=400,width=600');


                mywindow.document.write('<html><head><title>' + document.title  + '</title>');
                mywindow.document.write('<style>' +
                    'table, th, td{' +
                         'border: 1px solid black;' +
                         'border-collapse: collapse;' +
                    '}  </style>');
                mywindow.document.write('</head><body >');
                mywindow.document.write('<h3>' + heading + '</h3>');
                mywindow.document.write('<div>' + document.getElementById(elem).innerHTML + '</div>');
                mywindow.document.write('</body></html>');

                mywindow.document.close(); // necessary for IE >= 10
                mywindow.focus(); // necessary for IE >= 10*/

                mywindow.print();
                mywindow.close();

                return true;

            }

			function getEmployees(async){
				getAjax(showEmployees,"scripts/getemployees.php",async);
			}

			function showEmployees(xhttp){
				var employees = JSON.parse(xhttp.responseText);
				var selectors = document.getElementsByClassName("employee-selection");
	
	     		for(var i = 0; i < selectors.length; i++){

					var option = "";
					while(selectors[i].options.length > 0){                
	    				selectors[i].remove(0);
					}
					option = document.createElement("option");
					option.text = "Select employee";
					option.value = "default";
					selectors[i].add(option);
					option = document.createElement("option");
					option.text = "All";
					option.id = "all";
					if(selectors[i].getAttribute("id") != "select-employee")
		    			selectors[i].add(option);
					for (var j = 0; j < employees['employees'].length; j++) {
						option = document.createElement("option");
						option.text = employees['employees'][j].lastname + ", " + employees['employees'][j].name + " (" + employees['employees'][j].id +")";
						option.id = employees['employees'][j].id;
						option.value = employees['employees'][j].id;
						selectors[i].add(option);	
					}
				}
			}
			
			
	  		//TODO:convert to jquery
			function enablePatientEdit(value){
				document.getElementById("patient-name").readOnly = !value;
		     	document.getElementById("patient-last-name").readOnly = !value;
		     	if(value){
		     		document.getElementById("edit-patient").style.display = "none";
		     		document.getElementById("save-patient-changes").style.display = "inline";
		     		document.getElementById("cancel-edit-patient").style.display = "inline";
		     	}else{
					document.getElementById("edit-patient").style.display = "inline";
		     		document.getElementById("save-patient-changes").style.display = "none";
		     		document.getElementById("cancel-edit-patient").style.display = "none";
		     	}
			}
			function enableLocationEdit(value){
				document.getElementById("location-name").readOnly = !value;
		     	if(value){
		     		document.getElementById("edit-location").style.display = "none";
		     		document.getElementById("save-location-changes").style.display = "inline";
		     		document.getElementById("cancel-edit-location").style.display = "inline";
		     	}else{
					document.getElementById("edit-location").style.display = "inline";
		     		document.getElementById("save-location-changes").style.display = "none";
		     		document.getElementById("cancel-edit-location").style.display = "none";
		     	}
			}
		
			
			function createCalendar(){
				var selector = document.getElementById("sched-month");
				var month = selector[selector.selectedIndex].text;
				var monthNum = selector[selector.selectedIndex].value;
				var yearSelector = document.getElementById("sched-year")
				var year = yearSelector[yearSelector.selectedIndex].value;
				var patientSelector = document.getElementById("add-sched-patient");
				var patient = patientSelector[patientSelector.selectedIndex].value;
				var patientName = patientSelector[patientSelector.selectedIndex].text;
				if(patient == "default"){
					patientSelector.style.border="1px solid red";
					document.getElementById("select-emp-lbl").style.color="red";
					return;
				}else{
					patientSelector.style.border="1px solid rgb(169, 169, 169)";
					document.getElementById("select-emp-lbl").style.color="black";
				}
				if(month == "Select month:"){
					selector.style.border="1px solid red";
					document.getElementById("select-emp-lbl").style.color="red";
					return;
				}else{
					selector.style.border="1px solid rgb(169, 169, 169)";
					document.getElementById("select-emp-lbl").style.color="black";
				}
				if(year == "default"){
					yearSelector.style.border="1px solid red";
					document.getElementById("select-emp-lbl").style.color="red";
					return;
				}else{
					yearSelector.style.border="1px solid rgb(169, 169, 169)";
					document.getElementById("select-emp-lbl").style.color="black";
				}
				monthNum = parseInt(monthNum);
				year = parseInt(year);
				var date = new Date(parseInt(year),monthNum,1);
				monthNum++;
				var monthEnd = new Date(year,monthNum,0).getDate();
				var offset = date.getDay();
				//var content = "<h5>" + patientName + "</h5>";
				var content = "<form id='calendar' >";
				content += "<fieldset>";
				content += "<legend>" + patientName +"</legend>";
				content += "<table>";
				content += "<caption>" + month + " - " + year + "</caption>";
				content += "<tr><th>Sun</th><th>Mon</th><th>Tue</th><th>Wed</th><th>Thu</th><th>Fri</th><th>Sat</th></tr>";
				for (var i = 0;i < monthEnd + offset;) {
					content += "<tr>";
					for (var j = 0; j <= 6; j++) {
						if(i >= offset & i < (monthEnd + offset)){
							content += "<td class='chkboxcell'><input type='checkbox' class='calendar-checkbox' value='" + (i - (offset-1)) + "'/>" + (i - (offset-1)) + "</td>";
						}else{
							content += "<td></td>";
						}
						i++;
					};
						content += "</tr>";
				};
				content += "</table>";
				content += "<label id='maxhourslbl'>Max hours per day:</label>";
				content += "<input type='text' id='maxHours'/><br>";
				content += "<input type='button' value='Submit' onclick='addSchedule(null)'/>";
				content += "</fieldset>";
				content += "</form>";
				document.getElementById("maincontent").innerHTML=content;
				document.getElementById("maincontent").style.display="block";
			}
			
			function jump(element){
				var target = element[element.selectedIndex].label;
				document.getElementById(target).scrollIntoView(true);
			}
		</script>
	</head>
	<body>
		<div id="headingdiv">
			<img id="essylogo" src="images/essylogo.png"/>
			<nav>
				<a class="accountLinks"><button class="messagesbutton" id="msgbtn"></button></a>
				<a class="accountLinks" disabled><?php echo($_SESSION["empname"]);?></a>
				<a class="accountLinks" disabled>My Account</a>
				<!-- <a href="myprofile.php" class="accountLinks">My Profile</a> -->
				<a href="logout.php" class="accountLinks">Log Out</a>
			</nav>
		</div>
		
		<div id="menudiv">
			<div class="navbuttons" id="totalsButton" ><p>Week Totals</p></div>
			<div class="navbuttons dropdown" id="timesheetsButton" ><p >Time sheets</p><div id="timesheetmenu" class="dropdown-content" ><p id="viewtimesheet">View timesheets</p><p id="searchtsbtn">Search visit</p><p id="urdatebtn">Restrict uploads</p></div></div>
			<div class="navbuttons dropdown" id="employeesButton" ><p >Employees</p><div id="empdropdown" class="dropdown-content" ><p id="searchempbtn">Search</p><p id="addempbtn">Add New</p></div></div>
			<div class="navbuttons dropdown" id="locationButton" ><p >Location</p><div id="locdropdown" class="dropdown-content" ><p id="searchlocsbtn">View Locations</p><p id="addlocbtn">Add Location</p></div></div>
			<div class="navbuttons dropdown" id="patientsButton" ><p >Patients</p><div id="ptdropdown" class="dropdown-content" ><p id="searchptbtn">Search</p><p id="addptbtn">Add New</p></div></div>
            <div class="navbuttons dropdown" id="scheduleButton" ><p >Schedules</p><div id="schdropdown" class="dropdown-content" ><p id="schedulebtn">Search</p><p id="schedreportbtn">Schedule Report</p><p id="addschbtn">Add New</p></div></div>
			<div class="navbuttons messagesbutton" id="messagesbutton"><p>Messages</p></div>
		</div>	
		<!--get totals-->
		<div class="options" id="totals">
				<fieldset class="optionsForms" id="totalsOptions">
					<legend>Select employee(s) and date options:</legend>
					<label style="display:inline-block;width:200px" id="selectemplbl">Select employee:</label>
					<label>Week ending on:</label>
					<br/>
					<select class="employeeSelection" id="totalsEmployeeSelection" name="employee" >
						<option value="default" selected>Select employee</option>
						<option id="all" value="all" >All</option>
						<option id="active" value="active">Show only active</option>
					</select>
					<input type="text" name="enddate" id="week2enddate" />
					<input type="button" value="Ok" id="viewtotalhours" name ="viewTotalHours" / >
				</fieldset>
		</div>
		<!-- get timesheets -->		
		<div class="options" id="timesheets">
			<fieldset class="optionsForms" id="timesheetOptions">
				<legend>Select employee(s) and date options:</legend>
				<label style="margin-right:10px;display:inline-block;width:200px" id="selectptlbl">Select employee:</label>
				<label style="margin-right:10px;display:inline-block;width:100px">Start date: </label><label style="display:inline-block;width:100px">End date:</label><br/>
				<select class="employeeSelection" style="margin-right:10px;width:200px" id="timesheetEmployeSelection">
					<option value="default" selected>Select employee</option>
				</select>
				<input id="startdate" type="text" style="margin-right:10px;width:100px" name="startdate"/>
				<input id="enddate" type="text" style="margin-right:10px;width:100px;" name="enddate"/>
				<input type="button" value="Ok" id="viewtotalhours" name ="viewtimesheets" onclick="getTimesheets()"/ >
			</fieldset>
		</div>
		<!-- search visit -->
		<div class="options" id="timesheetsearch">
			<fieldset class="optionsForms" id="searchtimesheetOptions">
				<legend>Search for visit:</legend>
				<label style="display:inline-block;width:200px" id="">Enter visit ID:</label>
				<input type="text" id="tssearchid"/>
				<input type="button" value="Search" id="searchtimesheetbtn" onclick="searchTimesheets()"/ >
			</fieldset>
		</div>
		<!-- set ur date -->
		<div class="options" id="seturdate">
			<fieldset class="optionsForms" id="seturdateOptions">
				<legend>Select timesheet upload restriction date:</legend>
				<input type="text" id="urdate"/>
				<input type="button" value="Save" id="seturdatebtn" onclick="setURDate()"/ >
			</fieldset>
		</div>
		<!-- employee search -->
		<div class="options" id="employees">
				<fieldset class="optionsForms" id="employeeOptions">
					<legend>Select employee options:</legend><br/>
					<label> Search by Id:</label>
					<input type="text" id="searchEmployeeById" size="4"/>
					<select class="employeeSelection" name="employee" id="selectemployee">
						<option value="default" selected>Select employee</option>
					</select>
					<input type="button" value="Ok" id="showemployee" name ="showEmployee" />
				</fieldset>
		</div>
		<!-- location search -->
		<div class="options" id="locations">
			<fieldset class="optionsForms" id="locationOptions">
				<legend>Search locations:</legend><br/>
				<select class="locationSelection" name="location" id="selectlocation" >
					<option value="default" selected>Select location</option>
				</select>
				<input type="button" value="Ok" id="showlocation" name ="showLocation" />
			</fieldset>
		</div>
		<!-- patient search -->
		<div class="options" id="patients">
			<fieldset class="optionsForms" id="patientOptions">
				<legend>Select patient options:</legend><br/>
				<label> Search by Id:</label>
				<input type="text" id="searchPatientById" size="4"/>
				<select class="patientSelection" name="patient" id="selectpatient" >
					<option value="default" selected>Select patient</option>
				</select>
				<input type="button" value="Ok" id="showpatient" name ="showPatient" />
			</fieldset>
		</div>
		<!-- schedule options -->
		<!-- view schedules -->
		<div class="options" id="viewschedule">
			<fieldset class="optionsForms" id="scheduleOptions">
				<legend>Select patient:</legend>
				<label> Search by Id:</label>
				<input type="text" id="searchSchedPatientById" size="4"/>
				<select class="patientSelection" name="patient" id="schedpatient" >
					<option value="default" selected>Select patient:</option>
				</select>
			</fieldset>
		</div>
        <div class="options" id="schedulereport">
            <fieldset class="optionsForms" id="scheduleOptions">
                <legend>Schedule Report</legend>
                <input type="radio" name="report-option" value="last-sched-date" checked/>Last Schedule Date
                <input type="radio" name="report-option" value="no-sched" />No active schedules
                <input type="button" value="OK" id="schedReportBtn"/>
            </fieldset>
        </div>
		<div class="options" id="addschedule">
			<fieldset class="optionsForms" id="scheduleOptions">
				<legend>Select patient:</legend>
				<label> Search by Id:</label>
				<input type="text" id="searchAddSchedPatientById" size="4"/>
				<select class="patientSelection" name="patient" id="addschedpatient" >
					<option value="default" selected>Select patient:</option>
				</select>
				<label>Schedule month:</label>
				<select class="monthSelection" name="month" id="schedmonth" >
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
				<select class="yearSelection" name="year" id="schedyear" >
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
		</div>
		<!-- messages -->
		<div class="options" id="messageoptions">
			<fieldset>
					<button class="messagesbutton" id="inboxbtn" >Inbox</button>
					<input type="button" value="New Message" id="composebtn"/ >
			</fieldset>
		</div>
		<div class="content" id="maincontent">
		</div>
		
		<div  class="content" id="maincontent" >
		</div>
		<div id="footerdiv">
			<p>&copy; 2014 - <span id="currentyear" ><script >document.getElementById("currentyear").innerHTML= new Date().getFullYear();</script></span> Essy Nursing Services. All rights reserved. </p>
		</div>
	</body>
</html>

