<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use models\Schedule;

class ScheduleController extends Controller
{
    /**
     * Show the schedules for the given patient.
     *
     * @param  int  $id
     * @return Response
     */
    public function show(Request $request, $id=null)
    {
    	if (isset($id)) {
    		return view('patient.schedule', ['schedule' => Schedule::findOrFail($id)]);
    	} else {
    		$reportType = $request->input('report_type');
    		if (isset($reportType)) {
    			return view('patient.schedule', ['schedule' => Schedule::orderBy('date')->get()]);
    		}	
    	}
        
    }

    
    public function delete($id)
    {
    	$schedule = Schedule::find($id);
    	$schedule->delete();
    }

	public function store(Request $request){
		$patientId = $request->input('patient-id');
		$dates = $request->input('date-*');
		$maxHours = $request->input('max-hours');
		foreach($date as $dates){
			Schedule::create(array(
				'patient_id' => $patientId,
	        	'date' => $date,
	        	'max_hours' => $maxHours
			));
		}
	}

	public function update_schedule($id, $max_hours)
	{
		$schedule = Schedule::findOrFail($id);
		$schedule->max_hours = $max_hours;
		$schedule->save();
	} 
}
