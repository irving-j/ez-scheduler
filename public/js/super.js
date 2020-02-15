// var a1 = $.ajax({
//      url: '/path/to/file',
//      dataType: 'json'
//     }),
//     a2 = a1.then(function(data) {
//      // .then() returns a new promise
//         return $.ajax({
//             url: '/path/to/another/file',
//             dataType: 'json',
//             data: data.sessionID
//         });
//  });

// a2.done(function(data) {
//     console.log(data);
// });

var getEmployee = function(data, textStatus, jqXHR){
    return $.ajax({
        url: 'employee/' + data["employee_id"],
        data: {r : data["render"]},
        type: 'get',
        cache: false
    });
}
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
var populateMainContent = function(html, hideOptions){
    if (hideOptions === true) {
        $("div#main-content").empty();
        $("div#options-section").hide();
    }
    $("div#main-content").empty();
    $("div#main-content").hide().show(0);
    $("div#main-content").html(html);
}
var populateOptionsSection = function(html){
    $("div#main-content").empty();
    $("div#options-section").empty();
    $("div#options-section").hide().show(0);
    $("div#options-section").html(html);
}
$(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $("div#totals-button").click(function (){
        $("div#main-content").empty();
        $("div#options-section").load('/timesheet/report/options');
    });
    $("p#view-emp-ts-opt").click(function (){
        $("div#main-content").empty();
    	$("div#options-section").load('/timesheet/view/options');
    });
    $("p#search-timesheet-opt").click(function (){
        $("div#main-content").empty();
        $("div#options-section").load('/timesheet/search/options');
    });
    $("p#ur-date-btn").click(function (){
        $("div#main-content").empty();
        $("div#options-section").load('/urdate');
    });
    // $("p#ur-date-btn").click(function (){
    //     var url = "scripts/urdate.txt";
    //     $.get(url, function(data, status){
    //         var date = data.split("-");
    //         $( "#urdate" ).datepicker({ dateFormat: 'mm-dd-yy' });
    //         $( "#urdate" ).datepicker("setDate", date[1] + "-" + date[2] + "-" + date[0]);
    //     });
    // });

    $("#search-emp-btn").click(function (){
        $.get('/search-employee', function(data){
            populateOptionsSection(data);
        });
    });
    $("#new-employee").click(function (){
        $("div#options-section").empty();
        $("div#options-section").hide();
        $("div#main-content").load('/new-employee');
    });

    $("#search-pt-btn").click(function (){
        $.get('/search-patient', function(data){
            populateOptionsSection(data);
        });
    });
    $("#new-patient").click(function (){
        $("div#options-section").empty();
        $("div#options-section").hide();
        $("div#main-content").load('/new-patient');
    });
    $("#new-location").click(function (){
        $("div#options-section").empty();
        $("div#options-section").hide();
        $("div#main-content").load('/new-location');
    });
    $("#schedule-btn").click(function (){
        $.get('/search-schedule', function(data){
            populateOptionsSection(data);
        });
    })
    $("#add-sch-btn").click(function (){
        $("div#options-section").load('/new-schedule');
    })
    $("#sched-report-btn").click(function (){
        $("div#main-content").load('/schedule-report');
    })
    $("#search-locs-btn").click(function (){
        $.get('/search-location', function(data){
            populateOptionsSection(data);
        });
    });
    $("div#notifications-button").click(function (){
        $("div#options-section").empty();
        $("div#options-section").hide();
    });
    $("#sched-patient").change(function(){
        if($('#select-patient option[value='+ this.value +']').length > 0){
            $(this).val(this.value);
            
            getSchedule();
        }else{
           
            $("#main-content").html("No schedules found.");
        }
    });
   
    $("#cancel-edit").click(function(){
        enableedit(false);
        var employeeId = $("#employee-id").val();
        getEmployee(employeeId);
    });
    $("#cancel-edit-patient").click(function(){
        enablePatientEdit(false);
        var patientId = $("#patient-id").val();
        getPatient(patientId);
    });
    $("#cancel-edit-location").click(function(){
        enableLocationEdit(false);
        var locationid = $("#location-id").val();
        getLocation(locationid);
    });
   

    $("#sched-report-btn").click(function(event){
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

    $(function() {
        $( "#start-date" ).datepicker({ dateFormat: 'mm-dd-yy' });
        $( "#start-date" ).datepicker("setDate", new Date());
        $( "#end-date" ).datepicker({ dateFormat: 'mm-dd-yy' });
        $( "#end-date" ).datepicker("setDate", new Date());
       
        $( "#sched-start-date" ).datepicker({ dateFormat: 'mm-dd-yy' });
        $( "#sched-start-date" ).datepicker("setDate", new Date());
        $( "#sched-end-date" ).datepicker({ dateFormat: 'mm-dd-yy' });
        $( "#sched-end-date" ).datepicker("setDate", new Date());

        $( "#schedule-month").datepicker({ dateFormat: 'mm-dd-yy'});
        $( "#schedule-month").datepicker("setDate", new Date());
    }); 
});
$("click","a.msg-link",function(){
    
});
$("click","input#select-all",function(){
        $("input:checkbox").prop("checked", $("input:checkbox").prop("checked"));       
});
$("click","button#delete-msg",function(){
           
});
$("click","button.edit-schedule" , function(){
    $("button.edit-schedule").prop("disabled",true);
});

$(document).on("click", "input#add-employee", function(e){
    e.preventDefault();
    var addEmployee = $.ajax({
        url: '/employee',
        type: 'post',
        data: $('form#new-employee-form').serialize(),
    }),
    showEmployeeProfile = addEmployee.then(function(data){
        return getEmployee(
            {
                employee_id : data["employee_id"],
                render: true
            }
        );
    });
    showEmployeeProfile.done(function(data){
        populateMainContent(data);
    });
});
$(document).on("submit", "form#search-employee", function(e){
    e.preventDefault();
    getEmployee(
        {
            employee_id : ("input[id=emp-id]").val(),
            render : true
        })
    .done(function(data){
        populateMainContent(data);
    });
});
$(document).on("change", "select#select-employee", function(e){
    $.ajax({
        url: '/employee/' + $("select#select-employee option:selected").attr("value"),
        type: 'get',
        data: {
            r : true
        }
    }).done(function(data){
        populateMainContent(data);
    });
});
$(document).on("change", "iput#search-patient-id", function(e){
    //todo: set drop box selected option
});
$(document).on("submit", "form#employee-profile-form", function(e){
    var employee_id = $("input[id=employee-id]").val();
    e.preventDefault();
    var updateEmployee = $.ajax({
        url: '/employee/' + employee_id,
        type: 'put',
        data: $('form#employee-profile-form').serialize(),
    }),
    showEmployeeProfile = updateEmployee.then(function(data, textStatus, jqXHR){
        data['render'] = true;
        return getEmployee(data, textStatus, jqXHR);
    });
    showEmployeeProfile.done(function(data, textStatus, jqXHR){
        populateMainContent(data);
    });
});
$(document).on("submit", "form#assign-patient", function(e){
    var employee_id = $("input#employee-id").val();
    e.preventDefault();
    var updateEmployee = $.ajax({
        url: '/employee/' + employee_id + '/patient/' + $("select#assignable-patients option:selected").attr("value"),
        type: 'post'
    }),
    showEmployeeProfile = updateEmployee.then(function(data, textStatus, jqXHR){
        return getEmployee({
            'render': true,
            'employee_id': employee_id
        }, textStatus, jqXHR);
    });    
    showEmployeeProfile.done(function(data, textStatus, jqXHR){
        populateMainContent(data);   
    });
});
$(document).on("submit", "form#unassign-patient", function(e){
    var employee_id = $("input#employee-id").val();
    e.preventDefault();
    $.ajax({
        url: '/employee/' + employee_id + '/patient/' + $("select#assigned-patients option:selected").attr("value"),
        type: 'delete'
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
$(document).on("submit", "form#assign-location", function(e){
    var employee_id = $("input#employee-id").val();
    e.preventDefault();
    var updateEmployee = $.ajax({
        url: '/employee/' + employee_id + '/location/' + $("select#assignable-locations option:selected").attr("value"),
        type: 'post'
    }),
    showEmployeeProfile = updateEmployee.then(function(data, textStatus, jqXHR){
        return getEmployee({
            'render': true,
            'employee_id': employee_id
        }, textStatus, jqXHR);
    });    
    showEmployeeProfile.done(function(data, textStatus, jqXHR){
        populateMainContent(data);   
    });
});
$(document).on("submit", "form#unassign-location", function(e){
    var employee_id = $("input#employee-id").val();
    e.preventDefault();
    $.ajax({
        url: '/employee/' + employee_id + '/location/' + $("select#assigned-locations option:selected").attr("value"),
        type: 'delete'
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
$(document).on("focus","#employee-ur-date", function(e){
    $( "#employee-ur-date" ).datepicker({ dateFormat: 'yy-mm-dd' });
    $( "#employee-ur-date" ).datepicker("setDate", new Date());
    //$( "#employee-ur-date" ).datepicker("disable");
})
$(document).on("focus","#week-2-end-date", function(e){
    $( "#week-2-end-date" ).datepicker({ dateFormat: 'yy-mm-dd' });
    $( "#week-2-end-date" ).datepicker("setDate", new Date());
    //$( "#employee-ur-date" ).datepicker("disable");
})
$(document).on("focus","#start-date", function(e){
    $( "#start-date" ).datepicker({ dateFormat: 'yy-mm-dd' });
    $( "#start-date" ).datepicker("setDate", new Date())
    //$( "#employee-ur-date" ).datepicker("disable");
})
$(document).on("focus","#end-date", function(e){
    $( "#end-date" ).datepicker({ dateFormat: 'yy-mm-dd' });
    $( "#end-date" ).datepicker("setDate", new Date());
    //$( "#employee-ur-date" ).datepicker("disable");
})
$(document).on("focus",".has-date-picker", function(e){
    $(this).datepicker({ dateFormat: 'yy-mm-dd' });
    $(this).datepicker("setDate", new Date());
    //$( "#employee-ur-date" ).datepicker("disable");
})
$(document).on("submit", "form#add-new-patient-form", function(e){
    e.preventDefault();
    $.ajax({
        url: '/patient',
        type: 'post',
        data: $('form#add-new-patient-form').serialize()
    }).done(function(data){
        $("div#options-section").empty();
        $("div#options-section").hide();
        getPatient({
            patient_id:  data['patient_id'],
            render: true
        }).done(function(data){
            populateMainContent(data);
        });
    });
});
$(document).on("submit", "form#search-patient", function(e){
    e.preventDefault();
        $.ajax({
            url: '/patient/' + $("input[id=search-patient-id]").val(),
            data: {
                r: true
            },
            type: 'get'
        }).done(function(data){
            populateMainContent(data);
        });
});
$(document).on("change", "select#select-patient", function(e){
    $.ajax({
        url: '/patient/' + $("select#select-patient option:selected").attr("value"),
        data: {
         	r: true
        },
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

$(document).on("submit", "form#assign-aide", function(e){
    var patientId = $("input#patient-id").val();
    e.preventDefault();
    $.ajax({
        url: '/patient/' + patientId + '/employee/' + $("select#assignable-aide option:selected").attr("value"),
        type: 'post'
    }).done(function(jqxhr){
        getPatient(
        {
            patient_id : patientId,
            render : true
        }).done(function(data){
            populateMainContent(data);
        });                  
    });
});

$(document).on("submit", "form#unassign-aide", function(e){
    var patientId = $("input#patient-id").val();
    e.preventDefault();
    $.ajax({
        url: '/patient/' + patientId + '/employee/' + $("select#assigned-aide option:selected").attr("value"),
        type: 'delete'
    }).done(function(){
        getPatient(
        {
            patient_id : patientId,
            render : true
        }).done(function(data){
            populateMainContent(data);
        });
    });
});

$(document).on("submit", "form#assign-employee", function(e){
    var locationId = $("input#location-id").val();
    e.preventDefault();
    $.ajax({
        url: '/location/' + locationId + '/employee/' + $("select#assignable-employee option:selected").attr("value"),
        type: 'post'
    }).done(function(){
        getLocation(
        {
            location_id : locationId,
            render : true
        }).done(function(data){
            populateMainContent(data);
        });
    });
});

$(document).on("submit", "form#unassign-employee", function(e){
    var locationId = $("input#location-id").val();
    e.preventDefault();
    $.ajax({
        url: '/location/' + locationId + '/employee/' + $("select#assigned-employee option:selected").attr("value"),
        type: 'delete'
    }).done(function(){
        getLocation(
        {
            location_id : locationId,
            render : true
        }).done(function(data){
            populateMainContent(data);
        });
    });
});

$(document).on("submit", "form#add-new-location", function(e){
    e.preventDefault();
    $.ajax({
        url: '/location',
        type: 'post',
        data: $('form#add-new-location').serialize()
    }).done(function(jqxhr){
        populateMainContent(
            getLocation(
            {
                location_id : data["location_id"]
            })
        );
    });
});
$(document).on("change", "#select-location", function(e){
    e.preventDefault();
    $.ajax({
        url: '/location/' + $("select#select-location option:selected").attr("value"),
        data: {
            r: true
        },
        type: 'get'
    }).done(function(data){
        populateMainContent(data);
    });
});
$(document).on("submit", "form#timesheet-search-options", function(e){
    e.preventDefault();
    $.ajax({
        url: '/timesheet/' + $("input[id=ts-id]").val(),
        data: {
            r: true
        },
        type: 'get'
    }).done(function(data){
        populateMainContent(data);
    });
});
$(document).on("submit", "form#update-ur-date", function(e){
    e.preventDefault();
    $.ajax({
        url: '/urdate?r=true',
        data: $('form#update-ur-date').serialize(),
        type: 'put'
    }).done(function(jqxhr){
        location.reload();
    });
});
$(document).on("submit", "form#view-timesheets", function(e){
    e.preventDefault();
    $.ajax({
        url: '/timesheet/search?r=true',
        data: $('form#view-timesheets').serialize(),
        type: 'get',
        statusCode: {
            404: function() {
                populateMainContent("<p class='error-message'>No results found!</p>");
            }
        }
    }).done(function(data){
        populateMainContent(data);
    });
});
//schedule
$(document).on("change", "#schedule-patient", function(e){
    e.preventDefault();
    $.ajax({
        url: '/patient/' + $("select#schedule-patient option:selected").attr("value") + '/schedule',
        data: {
            r: true
        },
        type: 'get'
    }).done(function(data){
        populateMainContent(data);
    });
});
$(document).on("submit", "form#schedule-calendar", function(e){
    e.preventDefault();
    $.ajax({
        url: '/schedule',
        data: $('form#schedule-calendar').serialize(),
        type: 'post',
        statusCode: {
            404: function() {
                populateMainContent("<p class='error-message'>No results found!</p>");
            }
        }
    }).error(function(data){
    }).done(function(data){
        populateMainContent(data);
    });
});
function createCalendar(){
    var selector = document.getElementById("schedmonth");
    var month = selector[selector.selectedIndex].text;
    var monthNum = selector[selector.selectedIndex].value;
    var yearSelector = document.getElementById("schedyear")
    var year = yearSelector[yearSelector.selectedIndex].value;
    var patientSelector = document.getElementById("addschedpatient");
    var patient = patientSelector[patientSelector.selectedIndex].value;
    var patientName = patientSelector[patientSelector.selectedIndex].text;
    monthNum = parseInt(monthNum);
    year = parseInt(year);
    var date = new Date(parseInt(year),monthNum,1);
    monthNum++;
    var monthEnd = new Date(year,monthNum,0).getDate();
    var offset = date.getDay();
    //var content = "<h5>" + patientName + "</h5>";
    var content = "<form id='schedule-calendar' method='POST'>";
    content += "<fieldset>";
    content += "<legend>" + patientName +"</legend>";
    content += "<table>";
    content += "<caption>" + month + " - " + year + "</caption>";
    content += "<tr><th>Sun</th><th>Mon</th><th>Tue</th><th>Wed</th><th>Thu</th><th>Fri</th><th>Sat</th></tr>";
    var date = 0;
    for (var i = 0;i < monthEnd + offset;) {
        content += "<tr>";
        for (var j = 0; j <= 6; j++) {
            if(i >= offset & i < (monthEnd + offset)){
                date = (i - (offset-1));
                content += "<td class='chkboxcell'><input type='checkbox' class='calendar-checkbox' name='date-" + date + "' value='" + date + "'/>" + date + "</td>";
            }else{
                content += "<td></td>";
            }
            i++;
        };
            content += "</tr>";
    };
    content += "</table>";
    content += "<label id='maxhourslbl'>Max hours per day:</label>";
    content += "<input type='text' id='maxHours' name=max-hours/><br>";
    content += "<input type='submit' value='Submit' />";
    content += "</fieldset>";
    content += "</form>";
    document.getElementById("calendar").innerHTML=content;
    document.getElementById("calendar").style.display="block";
}