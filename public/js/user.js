var getPatient = function(data){
    return $.ajax({
        url: 'patient/' + data["patient_id"],
        data: {r : data["render"]},
        type: 'get',
        cache: false
    });
}
var getLocation = function(data){
    return $.ajax({
        url: 'location/' + data["location_id"],
        data: {r : true},
        type: 'get',
        cache: false
    });
}
var populateMainContent = function(html){
    $("div#main-content").hide().show(0);
    $("div#main-content").empty();
    $("div#main-content").html(html);
}
$(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $("div#total-button").click(function (){
        $("div#main-content").empty();
        $("div#main-content").load('/timesheet/report');
    });
    $("p#view-timesheet").click(function (){
        $("div#main-content").empty();
    	$("div#main-content").load('/timesheet/view');
    });
    $("p#search-timesheet").click(function (){
        $("div#main-content").empty();
        $("div#main-content").load('/timesheet');
    });
    $("div#timesheet-button").click(function () {
        $("div#main-content").empty();
        $("div#options-section").load('/timesheet-options');
    });
    $("div#visits-button").click(function () {
        $("div#options-section").load('/timesheet-edit-options', function(){
            $( "input.date-picker" ).datepicker({ dateFormat: 'mm-dd-yy' });
            $( "input.date-picker" ).datepicker("setDate", new Date());
            $( "input.date-picker" ).datepicker({ dateFormat: 'mm-dd-yy' });
            $( "input.date-picker" ).datepicker("setDate", new Date());
        });
    });
    
   
    // $("p#ur-date-btn").click(function (){
    //     var url = "scripts/urdate.txt";
    //     $.get(url, function(data, status){
    //         var date = data.split("-");
    //         $( "#urdate" ).datepicker({ dateFormat: 'mm-dd-yy' });
    //         $( "#urdate" ).datepicker("setDate", date[1] + "-" + date[2] + "-" + date[0]);
    //     });
    // });

    
    $("#cancel-edit").click(function(){
        enableedit(false);
        var employeeId = $("#employee-id").val();
        getEmployee(employeeId);
    });
    
    $("#view-timesheet").click(function(event){
        var reportType = $("input[name=report-option]:checked").val();
        e.preventDefault();
        $.ajax({
            url: '/schedule',
            type: 'get',
            data: {
                report_type : reportType
            }
        }).done(function(){
            getEmployee(
            {
                employee_id : employee_id,
                render : true
            }).done(function(data){
                populateMainContent(data);
            });
        });
    });
    
});

$("click","a.msg-link",function(){
    
});
$("click","input#select-all",function(){
        $("input:checkbox").prop("checked", $("input:checkbox").prop("checked"));       
});
$("click","button#delete-msg",function(){
           
});
$(document).on("submit", "form#delete-visit", function(e){
    var timesheetId = $("input#timesheet-id").val();
    e.preventDefault();
    $.ajax({
        url: '/timesheet/' + timesheetId,
        type: 'delete'
    }).done(function(){
        //delete element
    });
});
$(document).on("change", "select#select-patient", function(e){
    $.ajax({
        url: '/patient/' + $("select#select-patient option:selected").attr("value") + '/timecards',
        type: 'get'
    }).done(function(data){
        populateMainContent(data);
    });
});
$(document).on("submit", "form#timesheet-report", function(e){
	e.preventDefault();
    $.ajax({
        url: '/timesheet/report?r=true',
        data: $("form#timesheet-report").serialize(),
        type: 'get'
    }).done(function(data){
        populateMainContent(data);
    });
});
$(document).on("submit", "form#view-timesheets", function(e){
    e.preventDefault();
    $.ajax({
        url: '/timesheet/search?r=true',
        data: $('form#view-timesheets').serialize(),
        type: 'get'
    }).fail(function(data){
    }).done(function(data){
        populateMainContent(data);
    });
});
$(document).on("submit", "form.time-card", function(e){
    e.preventDefault();
    var timecardId = $(this).attr('data-timecard-id');
    $.ajax({
        url: '/timesheet',
        data: $(this).serialize(),
        type: 'post'
    }).fail(function(data){
        //show errors
    }).done(function(data){
        // $('div#timecard-' + timecardId).fadeOut(1000, function() {
        //     $(this).remove();
        // });
        $('div#timecard-' + timecardId).hide("slide", { direction: "right" }, 1000, function() {
           $(this).remove(); 
        });
    });
});
$(document).on('submit', 'form#visit-edit-options-form', function(e){
    e.preventDefault();
    $.ajax({
        url: '/timesheet-edit',
        data: $(this).serialize(),
        type: 'get'
    }).fail(function(data){
        populateMainContent(data);
    }).done(function(data){
        populateMainContent(data);
    });
});
$(document).on("click", "input.save-time-card", function(e){
    var timecardId = $(this).attr('data-timecard-id');
    $.ajax({
        url: '/timesheet/' + timecardId,
        data: $('form#time-card-' + timecardId).serialize(),
        type: 'put'
    }).fail(function(data){
        //show errors
    }).done(function(data){
        
    });
});
$(document).on("click", "input.delete-time-card", function(e){
    e.preventDefault();
    var timecardId = $(this).attr('data-timecard-id');
    $.ajax({
        url: '/timesheet/' + timecardId,
        type: 'delete'
    }).fail(function(data){
        //show errors
    }).done(function(data){
        // $('div#timecard-' + timecardId).fadeOut(1000, function() {
        //     $(this).remove();
        // });
        $('form#time-card-' + timecardId).hide("slide", { direction: "right" }, 1000, function() {
           $(this).remove(); 
        });
    });
});