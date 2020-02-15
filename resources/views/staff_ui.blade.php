
application/x-httpd-php staffaccount.php
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
				$("div.navbuttons").click(function(){
					//$("div#maincontent").css("display","none");
				});
				$("div#timesheetbutton").click(function(){
					$("#maincontent").empty();
					$(".content").hide();
					$("div.options").hide();
					$("#messages").hide();
					$("div#timesheets").show();
					var d = new Date($("#urdate").val());
					d.setTime( d.getTime() + d.getTimezoneOffset()*60*1000 + 86400000);							
					d = new Date(d.getTime());
					$( "#weekstart" ).datepicker("option", 'minDate', d);
				});
				$("div#visitsbutton").click(function (){
					$("#maincontent").empty();
					$(".content").hide();
					$("div.options").hide();
					$("#messages").hide();
					$("div#viewtimesheets").show();
				});
				$("div#editvisitsbutton").click(function (){
					$("#maincontent").empty();
					$(".content").hide();
					$("div.options").hide();
					$("#messages").hide();
					$("div#deletevisits").show();
				});

				$(".messagesbutton").click(function (){
					$("#messages").hide();
					$(".content").hide();
					$("#maincontent").empty();
					$("div.options").hide();
					$("div#messageoptions").show();	
					getMessages();
				});
				$("#composebtn").click(function(){
					//messages is composer div
					$("#maincontent").empty();
					$("#maincontent").hide();
					$("#messageviewer").hide();
					$("#messages").show();
					$("#msgrecipients").empty();
					$("#newmsgsubject").val("");
					$("#newmsgbody").val("");
					$("#messages").css("height","600px");
					getRecipients(true);
				});

				$("#cancel").click(function(){
					$("#prevtimesheet").css("display","none");
					$("#maincontent").empty();
					$("#maincontent").css("display","none");
					
				});
				$(".cancel").click(function(){
					$("this").empty();
				});
				$("#confirmnav>button").click(function(){
					$("#prevtimesheet").html("");
					$("#prevtimesheet").css("display","none");
					$("#confirmnav").css("display","none");
					$("#maincontent").css("display","block");
				});
				$("#slctrecipients").change(function() {
    				addRecipients();    				
				});
				$("#msgbody").click(function(){
					$('#msgbody').prop("selectionStart");
				});
				$(".messagesbutton").click(function (){
					$("#messages").hide();
					$("#messageviewer").hide();
					$("#maincontent").empty();
					$("div.options").hide();
					$("div.content").hide();
					$("div#messageoptions").show();	
					getMessages();
				});
				$("#deleteopen").click(function(){
					$("#messageviewer").hide();
					deleteOpenMessage();
				});
				$(function() {
					applyAccountSettings();
					getLocations();
					
				});
				$(function() {
					$( "#weekstart" ).datepicker({ dateFormat: 'yy-mm-dd' });
					$( "#weekstart" ).datepicker("setDate", new Date());
					$( "#startdate" ).datepicker({ dateFormat: 'yy-mm-dd' });
					$( "#startdate" ).datepicker("setDate", new Date());
					$( "#enddate" ).datepicker({ dateFormat: 'yy-mm-dd' });
					$( "#enddate" ).datepicker("setDate", new Date());
				});	
				
			});
			$(document).on("click","button.closebutton" ,function(){
				$(this).parent().parent().parent().remove();
			});
			$(document).on("click","input#okaddvisit" , function(){
				processVisit(this);
			});
			$(document).on("click","#cancelvisit" , function(){
				resetVisitFields(this);
			});
			$(document).on("click","button.editvisit" , function(){
				var url = "scripts/checkeditablevisit.php?id=" + this.value;
				var target = this;
				$.get(url, function(data, status){
					var response = JSON.parse(data);
					if(response["editable"] == "yes"){
						editVisit(target);
					}
        			else{
        				alert("This timecard cannot be edited due to upload restriction date. Please contact supervisor for more details");
        			}
    			});
			});
			$(document).on("click","button.deletevisit", function(){
				var url = "scripts/checkeditablevisit.php?id=" + this.value;
				var target = this;
				$.get(url, function(data, status){
					var response = JSON.parse(data);
					if(response["editable"] == "yes"){
						var ans = confirm("Are you sure you want to delete the selected entries?");
						if(ans){
							deleteVisit(target);
						}
					}
					else{
        				alert("This timecard cannot be deleted due to upload restriction date. Please contact supervisor for more details");
        			}
    			});
			});
			$(document).on("click","a.msglink",function(){
				$("#maincontent").empty();
				$("#maincontent").hide()
			});
			$(document).on("click","input#selectall",function(){
					$("input:checkbox").prop("checked", $("input:checkbox").prop("checked"));		
			});
			$(document).on("click","button#deletemsg",function(){
					deleteMessage();	
			});
			
			//get location assigned to employee
		function getLocations(){
     		getAjax(showLocations,"scripts/getassignedlocations.php",true);
		}
		function showLocations(xhttp){
			var locations = JSON.parse(xhttp.responseText);
			var selector = document.getElementById("timesheetlocations");
     		var option = "";
			for (i = 0; i < locations.length; i++) {
				option = document.createElement("option");
				option.text = locations[i].name;
				option.id = locations[i].id;
    			selector.add(option);
			}   
			showAllLocations(xhttp);
		}
		function getAllLocations(){
			getAjax(showAllLocations,"scripts/getalllocations.php",true);
		}
		function showAllLocations(xhttp){
			var locations = JSON.parse(xhttp.responseText);
			var selector = document.getElementById("reviewlocations");
     		var option = "";
			for (i = 0; i < locations.length; i++) {
				option = document.createElement("option");
				option.text = locations[i].name + " (" + locations[i].id +")";
				option.id = locations[i].id;
    			selector.add(option);
			}
		}
		// Timesheets
		function getTimesheets(){
			var startdate =  $('#startdate').datepicker({ dateFormat: 'yy-mm-dd' }).val();
			var enddate =  $('#enddate').datepicker({ dateFormat: 'yy-mm-dd' }).val();
			var location = document.getElementById("reviewlocations");
			var locationid = location[location.selectedIndex].id;
			getAjax(displayTimesheets,"scripts/getallvisits.php?locationid=" + locationid + "&startdate=" + startdate + "&enddate=" + enddate);
		}
		function displayTimesheets(xhttp){
			var content = "";
			if(xhttp.responseText != ""){
				document.getElementById("maincontent").innerHTML = content;
				var allvisits = JSON.parse(xhttp.responseText);
				for(var location in allvisits){
	     			for (var key in allvisits[location]) {
		     			content += "<table>";
		     			content += "<caption>" + key+ "</caption>";
		     			content += "<tr><th>Timecard ID</th><th>Location ID</th><th>Date</th><th>Time In</th><th>Time Out</th><th>Total</th><th colspan=2>Options</th></tr>";
		     			for (var visit in allvisits[location][key]) {
		     				content += "<tr><td class='visitid'>" + allvisits[location][key][visit].id + "</td><td class='locationid'>" + allvisits[location][key][visit].location_id + "</td><td class='editvisitdate'>" + allvisits[location][key][visit].date + "</td><td>" + allvisits[location][key][visit].timein + "</td><td>" + allvisits[location][key][visit].timeout + "</td><td>" + allvisits[location][key][visit].total + "</td><td><button class='editvisit' value='" + allvisits[location][key][visit].id + "' >Edit</button></td><td><button class = 'deletevisit' value='" + allvisits[location][key][visit].id + "'>Delete</button></td></tr>";
		     			}
						content +="</table>";
					}   
	     		}
			}else{
				content = "No results for the terms requested";
			}
			document.getElementById("maincontent").style.display="block";
	     	document.getElementById("maincontent").innerHTML = content;
  		}
  		// Timesheet input
		function showVisitInputs(){
			document.getElementById("confirmnav").style.display = "none";
			document.getElementById("maincontent").innerHTML = "";
			var selector = document.getElementById("timesheetlocations");
			if(selector[selector.selectedIndex].value != "default"){
				selector.style.border = "1px solid rgb(169, 169, 169)";
				document.getElementById("selectptlbl").style.color="black";
				if(document.getElementById("prevtimesheet") != null){
					document.getElementById("prevtimesheet").innerHTML = "";
				}
				document.getElementById('maincontent').style.visibility="visible";
				count = 0;
				var date = "";
				var location = document.getElementById("timesheetlocations");
				content = "<h4 id='ptname'>Enter timecard details for: " + location.options[location.selectedIndex].text + "</h4><input type='hidden' class='locationid' id='locationid' value='" + location.options[location.selectedIndex].id + "'/>";
				content += "<div class='timesheet'>";
				content += "<label class='visitlbl datelbl' >Date</label >";
				content += "<label class='visitlbl timelbl'>Time In</label >";
				content += "<label class='visitlbl timelbl'>Time Out</label>";
				content += "<label class='visitlbl totallbl'>Total</label>";
				content+= "</div>";
				var staticelements = "";
				var inputelements=""
				millisecs = 0;								
				weektotal = 0;
				wsdate =  $('#weekstart').val();
				var d = new Date(wsdate);
				d.setTime( d.getTime() + d.getTimezoneOffset()*60*1000 );
				millisecs = Date.parse(d);
				for(var i = 0; i < 7;i++){
					date = new Date(millisecs);
					if(date > new Date())
							break;
					date.setTime( date.getTime() + date.getTimezoneOffset()*60*1000 );
					content += "<div class='timesheet'>";	
					content += "<input class='visitdate data' type='text' value='" + date.toDateString().substr(0,15) + "' readonly />";
					content += "<input type='time' class='timein data'/>";
					content += "<input type='time' class='timeout data'/>";
					content += "<input type='text' class='visittotal data' readonly/>";
					content += "<input type='text' class='valid' value = 0 size='1' /><input type='text' class='processed' value = 0 size='1'/><br>";
					content += "<input type='button' value='Cancel' id='cancelvisit' class='timesheetbtn'/><input type='button' value='Ok' class='timesheetbtn' id='okaddvisit'></div>";
					count++;					
					millisecs += 86400000;		
				}
				content += "<div class='totaldiv'><label id='totalhourslabel'>Total hours: </label><input type='text' id='totalhours' readonly/><br /></div><button onclick='processTimesheet()'>Proccess Timesheet</button></div>";
				document.getElementById('maincontent').style.display="block";
				document.getElementById('maincontent').innerHTML = content;
				millisecs = 0;
				changeInputType();
			}
			else
			{
				selector.style.border="1px solid red";
				document.getElementById("selectptlbl").style.color="red";
			}
		}
		function changeInputType(){
			var timeinput = document.getElementsByClassName("timein");
			try {
    			if (!(timeinput[0].type === "time")) {
        			var _24hnotice = document.createElement("p");
        			_24hnotice.innerHTML="Please use 24 hour format. (e.g. 14:00 for 2:00pm)";
        			document.getElementById("maincontent").insertBefore(_24hnotice,document.getElementById("ptname").nextSibling);
    			} 
			} catch(e) {
				
    		}
		}
		function loadDoc(cFunc) {
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function() {
				if (xhttp.readyState == 4 && xhttp.status == 200) {
				  cFunc(xhttp);
				}
			xhttp.open("GET", request, true);
  			xhttp.send();
			}	
		}
		
		function processTimesheet(){
			var total = document.getElementById("totalhours");
			if(total.value != "error" && total.value > 0){
				document.getElementById("maincontent").style.display="none";
				var flag = 0, thistotal = 0;
				var weektotal = 0;
				var timesheet = document.getElementsByClassName("timesheet");
				var locationid = document.getElementById("locationid").value;
				var date, tin, tout, locationid,isprocessed;
				var alldates = document.getElementsByClassName("visitdate");
				var alltimeins = document.getElementsByClassName("timein");
				var alltimouts = document.getElementsByClassName("timeout");
				var alltotals = document.getElementsByClassName("visittotal");
				var processed = document.getElementsByClassName("processed");
				var valid = document.getElementsByClassName("valid");
				var location = document.getElementById("timesheetlocations");
				var content = "<p>Please review your time sheet before submitting.<br> Location name:" + location.options[location.selectedIndex].text + "</p>";
				content += "<table id='timesheetprev'><tr><th>Date</th><th>Time In</th><th>Time Out</th><th>Total</th></tr>";
				for (var i = 0; i < alldates.length; i++) {
					date = alldates[i].value;
	   				timein = alltimeins[i].value;
	   				timeout = alltimouts[i].value;
	   				isprocessed = processed[i].value;
	   				isvalid = valid[i].value;
	   				if(alltotals[i].value != ""){
	   					if((date != null || date != "") && (timein != null || timein != "") && (timeout != null || timeout != "") && isprocessed == 0 && isvalid == 1){
		   					thistotal = Number(alltotals[i].value);
		   					if(thistotal >= 0){
								weektotal += thistotal;
								if(thistotal > 0){	
									content += "<tr><td>" + date + "</td><td>" + timein + "</td><td>" + timeout + "</td><td>" + thistotal + "</td></tr>";
								}
		   					}
		   				}  	
	   				}						
				}
				if(weektotal > 0){
					content += "<tr><td colspan='2'></td><td>Timesheet totals:</td><td>" + weektotal + "</td></tr><table>"
					document.getElementById("prevtimesheet").style.display = "block"
					var confirmnav = document.getElementById("confirmnav");
					confirmnav.style.display = "block";
					var div = document.createElement("DIV");
					div.innerHTML = content;
					document.getElementById("prevtimesheet").innerHTML = "";
					document.getElementById("prevtimesheet").appendChild(div);
				}
			}		
		}
		function submitTimesheet(){
			var flag = 0, thistotal = 0;
			var weektotal = 0;
			var timesheet = document.getElementsByClassName("timesheet");
			var locationid = document.getElementById("locationid").value;
			var date, tin, tout, locationid,isprocessed;
			var alldates = document.getElementsByClassName("visitdate");
			var alltimeins = document.getElementsByClassName("timein");
			var alltimouts = document.getElementsByClassName("timeout");
			var alltotals = document.getElementsByClassName("visittotal");
			var processed = document.getElementsByClassName("processed");
			var valid = document.getElementsByClassName("valid");
			for (var i = 0; i < alldates.length; i++) {
				date = alldates[i].value;
   				timein = alltimeins[i].value;
   				timeout = alltimouts[i].value;
   				isprocessed = processed[i].value;
   				isvalid = valid[i].value;
   				if(alltotals[i].value != ""){
   					if((date != null || date != "") && (timein != null || timein != "") && (timeout != null || timeout != "") && isprocessed == 0 && isvalid == 1){
	   					thistotal = Number(alltotals[i].value);
	   					if(thistotal >= 0){
							weektotal += thistotal;
							if(thistotal > 0 && flag == 0){	
								element = timesheet[i];
								uploadVisit(date,timein,timeout,locationid,i);
							}
	   					}else{
	   						alltotals[i].value = "error";
	   						flag = 1;
	   					}
	   				}  	
   				}else{
   					if(processed[i].value == 0){
   						clearVisitDiv(i);
   					}			
   				}
   								
			}
			document.getElementById("totalhours").value = flag == 1 ? "error" : weektotal;
		}
		function submitEdit(element){
				var flag = 0;
				var tin = 0;
				var tout = 0;
				var visit = element.parentNode;
				var date = visit.getElementsByClassName("editvisitdate");
				var timein = visit.getElementsByClassName("edittimein");
				var timeout = visit.getElementsByClassName("edittimeout");
				var visitid = visit.getElementsByClassName("visitid");
				var locationid = visit.getElementsByClassName("locationid");
				var visittotal = visit.getElementsByClassName("editvisittotal");
				var total = 0;
				tin = Date.parse(new Date(date[0].value + 'T' + timein[0].value));
				tout = Date.parse(new Date(date[0].value + 'T' + timeout[0].value));				
				total = (tout - tin)/3600000;
	   			if(total >= 0 && timein[0].value != "" && timeout[0].value != ""){
					checkForEditConflict(element,date[0].value,timein[0].value,timeout[0].value,locationid[0].value,visitid[0].value);
					visittotal[0].value = total;
	   			}else{
	   				visittotal[0].value = "error";
	   			}				
		}
		function processVisit(element){
			var visit = element.parentNode;
			var visittotal = visit.getElementsByClassName("visittotal");
			var valid = visit.getElementsByClassName("valid");
			var total = 0;
			var tin = 0;
			var tout = 0;
			var date = visit.getElementsByClassName("visitdate");
			var timein = visit.getElementsByClassName("timein");
			var timeout = visit.getElementsByClassName("timeout");
			var datetoparse1 = new Date(date[0].value + ' ' + timein[0].value + ' UTC'); 
			var datetoparse2 = new Date(date[0].value + ' ' + timeout[0].value + ' UTC'); 
			//alert(datetoparse1);
			//alert(datetoparse2);
			if(timein[0].value.length >= 5 && timeout[0].value.length >= 5){
				tin = Date.parse(new Date(date[0].value + ' ' + timein[0].value + ' UTC'));
				tout = Date.parse(new Date(date[0].value + ' ' + timeout[0].value + ' UTC'));
				total = (tout - tin)/3600000;
				//alert("time="+timein[0].value+"\ntin ="+tin+"\n"+"time="+timeout[0].value+"\ntin ="+tout+"\n");		
	   			if(total >= 0){
	   				valid[0].value = 1;
	   				if(total > 0)
						checkForConflict(element,date[0].value, timein[0].value, timeout[0].value,-1);
	   			}else{
	   				visittotal[0].value = "error";
					valid[0].value = 0;
	   				addTotals();
	   			}
			}else{
				visittotal[0].value = "error";
				valid[0].value = 0;
   				addTotals();
			}
		}
		function checkForConflict(element,date, timein, timeout, visitid){
			var url = "scripts/getconflicts.php?";
			var request = url + "date=" + date + "&timein=" + timein + "&timeout=" + timeout + "&visitid=" + visitid;
			getAjaxForConflict(processVisitResult, element, request);
		}
		function processVisitResult(element,xhttp){
			var response = xhttp.responseText == '{}' ? xhttp.responseText : JSON.parse(xhttp.responseText);
			var visit = element.parentNode;
			var visittotal = visit.getElementsByClassName("visittotal");
			var valid = visit.getElementsByClassName("valid");
			var total = 0;
			if(response == '{}'){
				var tin = 0;
				var tout = 0;
				var date = visit.getElementsByClassName("visitdate");
				var timein = visit.getElementsByClassName("timein");
				var timeout = visit.getElementsByClassName("timeout");
				var datetoparse1 = new Date(date[0].value + ' ' + timein[0].value + ' UTC'); 
				var datetoparse2 = new Date(date[0].value + ' ' + timeout[0].value + ' UTC'); 
				//alert(datetoparse1);
				//alert(datetoparse2);
				tin = Date.parse(datetoparse1);
				tout = Date.parse(datetoparse2);
				var locationid = document.getElementById("locationid").value;
	   			total = (tout - tin)/3600000;
				//alert(tin);	
				//alert(tout);				
	   			if(total >= 0){
	   				var conflictdivs = visit.getElementsByClassName("conflictdiv");
					if(conflictdivs.length > 0){
						conflictdivs[0].remove();
					}
					visittotal[0].value = total.toFixed(2);
					valid[0].value = 1;
	   			}else{
	   				visittotal[0].value = "error";
					valid[0].value = 0;
	   			}
	   			addTotals();
			}else if(response['error'] == 'conflicts'){
				visittotal[0].value = "error";
				valid[0].value = 0;
				addTotals();
				showConflictSingle(element,response);
			}
		}
		function addTotals(){
			var flag = 0;
			var subtotal = 0;
			var alltotals = document.getElementsByClassName("visittotal");
			for (i = 0; i < alltotals.length; i++) {
   				if(alltotals[i].value != "error"){
   					subtotal += Number(alltotals[i].value);  					
   				}
   				else{
   					flag = 1;
   				}		
			}
			if(flag != 1){
				document.getElementById("totalhours").value = subtotal;
			}else{
				document.getElementById("totalhours").value = "error";
			}
		}
		function showConflictSingle(element,response){
  			var timesheets = document.getElementsByClassName("timesheet");
  			var conflictDiv = document.createElement("div");
  			conflictDiv.setAttribute("class","conflictdiv");
  			var parent = element.parentNode;
  			var content = "<table class='conflicttbl'><caption>These times are in conflict with other entries  in the system:</caption>";
			for(var i = 0; i < response['conflicts'].length; i++){
	     		content += "<tr><th>Visit ID</th><th>Date</th><th>Time In</th><th>Time Out</th><th>Location ID</th><th>Employee ID</th></tr>";
     			content += "<tr><td>" + response['conflicts'][i].id + "</td><td>" + response['conflicts'][i].date + "</td><td>" + response['conflicts'][i].timein + "</td><td>" + response['conflicts'][i].timeout + "</td><td>" + response['conflicts'][i].location_id + "</td><td>" + response['conflicts'][i].employee_id + "</td></tr>";  
			}
			content += "</table>";
			conflictDiv.innerHTML = content;
			var conflictdivs = parent.getElementsByClassName("conflictdiv");
			if(conflictdivs.length > 0){
				conflictdivs[0].remove();
			}
    		parent.appendChild(conflictDiv);
  		}
		function resetVisitFields(element){
			var flag = 0;
			var subtotal = 0;
			var parent = element.parentNode;
			var conflictdivs = parent.getElementsByClassName("conflictdiv");
			if(conflictdivs.length > 0){
				conflictdivs[0].remove();
			}
			var timein = parent.getElementsByClassName("timein");
			var timeout = parent.getElementsByClassName("timeout");
			var visittotal = parent.getElementsByClassName("visittotal");
			var valid = parent.getElementsByClassName("valid");
			var processed = parent.getElementsByClassName("processed");

			if(timein.length > 0)
				timein[0].value = "";
   			if(timeout.length > 0)
   				timeout[0].value = "";
   			if(visittotal.length > 0)
   				visittotal[0].value = ""; 			
   			if(valid.length > 0)
				valid[0].value = 0;
			if(processed.length > 0)
				processed[0].value = 0;
			addTotals();	
		}
		function checkForEditConflict(element,date,timein,timeout,locationid,visitid){
			var url = "scripts/getconflicts.php?";
			var request = url + "locationid=" + locationid + "&date=" + date + "&timein=" + timein + "&timeout=" + timeout + "&visitid=" + visitid;
			getAjaxForEditConflict(processEditResult, element, request);
		}	
		function getAjaxForEditConflict(callBack,element,request){
			var xhttp = ajaxFunction();
			xhttp.onreadystatechange = function() {
    			if (xhttp.readyState == 4 && xhttp.status == 200) {
    				callBack( xhttp);	
    			}
  			}
  			xhttp.open("GET", request, true);
  			xhttp.send();
		}
		function getAjaxForConflict(callBack, element, request){
			var xhttp = ajaxFunction();
			xhttp.onreadystatechange = function() {
    			if (xhttp.readyState == 4 && xhttp.status == 200) {
    				callBack(element, xhttp);	
    			}
  			}
  			xhttp.open("GET", request, true);
  			xhttp.send();
		}
		function processEditResult(xhttp){
			var response = xhttp.responseText == '{}' ? xhttp.responseText : JSON.parse(xhttp.responseText);
			var element = document.getElementsByClassName("editdiv");
			if(response == '{}'){
				submitEditedVisit(element[0]);
			}else if(response['error'] == 'conflict'){
				showEditConflict(element, response);
			}else if(response['error'] == 'schedule limit'){
				showScheduleLimitMessage(element);
			}
		}
		function submitEditedVisit(element){
			var tin = 0;
			var tout = 0;
			var visit = element.parentNode;
			var date = visit.getElementsByClassName("editvisitdate");
			var timein = visit.getElementsByClassName("edittimein");
			var timeout = visit.getElementsByClassName("edittimeout");
			var visitid = visit.getElementsByClassName("visitid");
			var locationid = visit.getElementsByClassName("locationid");
			var total = 0;
			var valid = visit.getElementsByClassName("valid");
			tin = Date.parse(new Date(date[0].value + 'T' + timein[0].value));
			tout = Date.parse(new Date(date[0].value + 'T' + timeout[0].value));				
			total = (tout - tin)/3600000;
   			var postingUrl = "scripts/uploadvisit.php";
			var data = "date=" + date[0].value + "&timein=" + timein[0].value + "&timeout=" + timeout[0].value + "&locationid=" + locationid[0].value + "&visitid=" + visitid[0].value;
			postAjax(postEditProcess,postingUrl, data);
		}
		function postEditProcess(xhttp){
			var response = JSON.parse(xhttp.responseText);
			if(response['result'] == true){
				alert("Visit edited successfully!");
				getTimesheets();
			}else if(response['result'] == false){
				var element = document.getElementsByClassName("editdiv");
				showEditConflict(element[0],response);
			}
		}
		function showEditConflict(element, response){
			var content = "<table class='conflicttbl'><caption style='color:red'>Your changes have conflicts:";
			for(var i = 0; i < response['conflicts'].length; i++){
	     		content += "<tr><th>Visit ID</th><th>Date</th><th>Time In</th><th>Time Out</th><th>Location ID</th><th>Employee ID</th></tr>";
     			content += "<tr><td>" + response['conflicts'][i].id + "</td><td>" + response['conflicts'][i].date + "</td><td>" + response['conflicts'][i].timein + "</td><td>" + response['conflicts'][i].timeout + "</td><td>" + response['conflicts'][i].location_id + "</td><td>" + response['conflicts'][i].employee_id + "</td></tr>";  
			}
			var conflicttbl = element[0].getElementsByClassName("conflicttbl");
			if(conflicttbl.length > 0){
				conflicttbl[0].remove();
			}
			content += "</table>";
			var conflictDiv = document.createElement("DIV");
			conflictDiv.innerHTML = content;
    		element[0].appendChild(conflictDiv);
		}
		function uploadVisit(date, timein, timeout, locationid,index){
			var postingUrl = "scripts/uploadvisit.php";
			var data = "date=" + date + "&timein=" + timein + "&timeout=" + timeout + "&locationid=" + locationid + "&index=" + index;
			postAjax(uploadVisitCallback,postingUrl, data);
		}
		
		function uploadVisitCallback(xhttp) {
			var response = JSON.parse(xhttp.responseText);
			if(response['result'] == true){
				clearVisitDiv(response['index']);
			
			}else if(response['result'] == false){
				showConflict(response);

			}
  		}
  		function clearVisitDiv(index){
  			var timesheets = document.getElementsByClassName("timesheet");
  			var processed = document.getElementsByClassName("processed");
  			var element = timesheets[index];
  			var label = document.createElement("label");
			var node = document.createTextNode("Processed");
			var flag = 0;
			var buttons = element.getElementsByClassName("timesheetbtn");
			processed[index].value = 1;
			for(var i = 0; i < buttons; i++){
    			buttons[i].remove();
    		}

			label.appendChild(node);
    		element.appendChild(label);
    		
    		
    		for(var i = 0; i < processed.length; i++){
    			if(processed[i].value != 1){
    				flag = 1;
    			}
    		}
    		if(flag == 0){
    			alert("All visits have been successfully uploaded!");
    			document.getElementById('maincontent').innerHTML = "";
    			document.getElementById('maincontent').style.display="none";
    		}
  		}
		function editVisit(element){
			var visit = element.parentNode.parentNode;
			var visitid = visit.getElementsByClassName("visitid");
			var date = visit.getElementsByClassName("editvisitdate");
			var locationid = visit.getElementsByClassName("locationid");
			var content = "<td colspan='9'><div class='editdiv'><input type='text' value='" + visitid[0].innerHTML + "' class='visitid' >";
			content += "<input type='hidden' value='" + locationid[0].innerHTML + "' class='locationid' ><label class='editlbl'>Date</label><label class='edittimelbl'>Time In</label>";
			content += "<label class='edittimelbl'>Time Out</label><label class='editlbl'>Total</label><br>";
			content += "<input type='text' class='editvisitdate' value = '" + date[0].innerHTML + "' readonly/><input type='time' class='edittimein'/>";
			content += "<input type='time' class='edittimeout'/><input type='total' class='editvisittotal' id='visittotal' readonly/><br>";
			content += "<button class='closebutton'>Cancel</button><button onclick='submitEdit(this)'class='submitEdit'>Submit</button></td>";
			var newTR = document.createElement("TR");
			newTR.innerHTML = content;
			visit.parentNode.insertBefore(newTR, visit.nextSibling);
		}
		function deleteVisit(element){
			var visit = element.parentNode.parentNode;
			var visitid = visit.getElementsByClassName("visitid");
			var postingUrl = "scripts/deletevisit.php";
			var data = "visitid=" + visitid[0].innerHTML;
			postAjax(postDeleteProcess,postingUrl, data);
		}
		function postDeleteProcess(xhttp){
			var response = xhttp.responseText;
			alert(response);
			getTimesheets();
		}
		function loadAccountSettings(){
			url = "scripts/accountsettings.php";
		}
		function applyAccountSettings(){
			var url = "scripts/initialsetup.php";
			getAjax(initialSetup,url,true);
		}
		function initialSetup(xhttp){
			var response = JSON.parse(xhttp.responseText);
			document.getElementById("msgbtn").innerHTML = response["newmessages"];
			document.getElementById("urdate").value = response["urdate"].substr(0,10);
			document.cookie = document.cookie + ";urdate=" + response["urdate"];
			document.cookie = document.cookie + ";blocked=" + response["blocked"];
			if(response["blocked"] == 1){
				document.getElementById('timesheetbutton').style.pointerEvents = 'none';				
			}
		}

		</script>
	</head>
	<body >
		<header>
			<nav>
				<a class="accountLinks"><button class="messagesbutton" id="msgbtn">0</button></a>
				<a class="accountLinks" disabled><?php echo($_SESSION["empname"]);?></a>
				<a class="accountLinks" disabled>My Account</a>
				<!--<a href="myprofile.php" class="accountLinks">My Profile</a>-->
				<a href="logout.php" class="accountLinks">Log Out</a>
			</nav>
		</header>
		<div id="topdiv">
			<img src="images/essylogo.png"/>		
		</div>
		<div id="menudiv">
			<div class="navbuttons" id="timesheetbutton"><p>Time sheets</p></div>
			<div class="navbuttons" id="visitsbutton"><p>Review Time sheets</p></div>
			<div class="navbuttons messagesbutton" id="messagesbutton"><p>Messages</p></div>
		</div>
		<div class="options" id="timesheets" >
			<div class="optionsforms" id="timesheetoptions"  >
				<fieldset>
					<legend>Select options for time sheet:</legend>
					<label id="selectptlbl">Select location: </label>
					<select class="locationselection" id="timesheetlocations" >
						<option value="default" selected="selected">Select location</option>
					</select>
					<label>Select start date: </label>
					<input type="text" id="weekstart" readonly/>
					<input type="button" value="Show" id="showtimesheet" onclick="showVisitInputs()"/ >
					<label>Upload restriction date: </label>
					<input type="text" id="urdate" readonly/>
				</fieldset>
			</div>
		</div>	
		<div class="options" id="viewtimesheets" >
			<form class="optionsforms" id="viewtimesheetsform" >
				<fieldset>
					<legend>Select location and date options:</legend>
					<label>Select location:</label>
					<select class="locationselection" id="reviewlocations">
						<option value="default" selected>Select location</option>
					</select>
					<label>Start date: </label><input class="startdate" type="text" id="startdate"/ >
					<label>End date:</label><input class="enddate" type="text" id="enddate"/>
					<input type="button" value="Show" onclick="getTimesheets()" / >
				</fieldset>
			</form>
		</div>
		<div class="options" id="deletevisits">
			<form class="optionsforms" id="deletevisitsform">
				<fieldset>
					<legend>Select location and date options:</legend>
					<select class="locationselection" >
						<option value="default" selected>Select location</option>
					</select>
					<input type="button" value="Show" onclick ="editTimesheets()"/ >
				</fieldset>
			</form>
		</div>
		<div class="options" id="messageoptions">
			<fieldset>
					<button class="messagesbutton" id="inboxbtn" >Inbox</button>
					<input type="button" value="New Message" id="composebtn"/ >
			</fieldset>
		</div>
		
		<div  class="content" id="maincontent" >
		</div>
		<div  class="content" id="prevtimesheet">	
		</div>
		<div id="confirmnav" >
			<button id="goback">Go Back</button>
			<button id="cancel">Cancel</button>
			<button onclick="submitTimesheet()">Submit</button>
		</div>
		<div id="footerdiv">
			<p>&copy; 2014 - <span id="currentyear" ><script >document.getElementById("currentyear").innerHTML= new Date().getFullYear();</script></span> Essy Nursing Services. All rights reserved. </p>
		</div>
	</body>
</html>

