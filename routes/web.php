<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
    return view('login');
});
Route::get('/login', function () {
    return view('login');
});
Route::get('/register', function () {
    return view('auth/register');
});
Route::post('/register', 'Auth\RegisterController@register')->name('register');
Route::post('/login', 'Auth\LoginController@authenticate')->name('login');
Route::get('/logout', 'Auth\LogoutController@logout')->name('logout');
//Auth::routes();
Route::view('/myaccount','myaccount');

//Employee routes
Route::get('/employee/{id?}', 'EmployeeController@get')->middleware('admin');
Route::post('/employee', 'EmployeeController@store')->middleware('admin');
Route::put('/employee/{id}','EmployeeController@update')->middleware('admin');
Route::delete('/employee/{id}','EmployeeController@delete')->middleware('admin');
Route::view('/search-employee','employee_search')->middleware('admin');
Route::view('/new-employee','new_employee')->middleware('admin');
Route::post('/employee/{employee_id}/patient/{patient_id}', 'EmployeeController@assign_patient')->middleware('admin');
Route::delete('/employee/{employee_id}/patient/{patient_id}', 'EmployeeController@remove_patient')->middleware('admin');
Route::post('/employee/{employee_id}/location/{location_id}', 'EmployeeController@assign_location')->middleware('admin');
Route::delete('/employee/{employee_id}/location/{location_id}', 'EmployeeController@remove_location')->middleware('admin');
Route::view('/employee/timesheet/view', 'timesheet_view');
//Patient routes
Route::get('/patient/{id?}','PatientController@get');
Route::get('/patient/{patient_id}/schedule/{month?}','PatientController@get_schedule');
Route::post('/patient/{patient_id}/employee/{employee_id}', 'PatientController@assign_aide')->middleware('admin');
Route::post('/patient', 'PatientController@store')->middleware('admin');
Route::put('/patient/{id}','PatientController@update')->middleware('admin');
Route::get('/patient/{id}/timecards', 'TimesheetController@getTimeCards');
Route::delete('/patient/{patient_id}/employee/{employee_id}','PatientController@unassign_aide')->middleware('admin');
Route::view('/search-patient','patient_search');
Route::view('/new-patient','new_patient')->middleware('admin');
//Timesheet routes
Route::get('/timesheet/report','TimesheetController@report')->middleware('admin');
Route::view('/timesheet/options', 'timesheet_report_options')->middleware('admin');
Route::get('/timesheet/search','TimesheetController@search')->middleware('admin');
Route::view('/timesheet/search/options','timesheet_search_options')->middleware('admin');
Route::get('/timesheet/{id?}','TimesheetController@get');
Route::get('/timesheet-edit', 'TimesheetController@getSubmittedTimesheets');
Route::put('/timesheet/{id}','TimesheetController@update');
Route::post('/timesheet','TimesheetController@store');
Route::delete('/timesheet/{id}','TimesheetController@delete');
Route::view('/timesheet/report/options', 'timesheet_report_options');
Route::view('/timesheet/view/options', 'admin_timesheet_view_options')->middleware('admin');
Route::view('/timesheet-options', 'timesheet_options');
Route::view('/timesheet-edit-options', 'timesheet_edit_options');
//Location routes
Route::get('/location/{id?}','LocationController@get');
Route::post('/location','LocationController@store')->middleware('admin');
Route::put('/location/{id}','LocationController@update')->middleware('admin');
Route::view('/new-location','new_location')->middleware('admin');
Route::view('/search-location','location_search');
Route::post('/location/{location_id}/employee/{employee_id}', 'LocationController@assign_employee')->middleware('admin');
Route::delete('/location/{location_id}/employee/{employee_id}', 'LocationController@remove_employee')->middleware('admin');

//Schedule routes
Route::post('/schedule','ScheduleController@store')->middleware('admin');
Route::put('/schedule/{id}','ScheduleController@update')->middleware('admin');
Route::delete('/schedule/{id}','ScheduleController@delete')->middleware('admin');
Route::get('/schedule/{id?}','ScheduleController@show');
Route::view('/search-schedule','schedule_search');
Route::view('/schedule-report','schedule_report')->middleware('admin');
Route::view('/new_schedule','new_schedule')->middleware('admin');
//Message routes
Route::post('/message','MessageController@store')->middleware('admin');
Route::get('/message/{id}','MessageController@show');
Route::delete('/message/{id}','MessageController@delete');
Route::view('/message','MessageController@show');

Route::view('/urdate','set_ur_date')->middleware('admin');
Route::put('/urdate','SettingsController@store')->middleware('admin');

