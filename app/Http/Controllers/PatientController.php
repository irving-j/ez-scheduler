<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use App\Patient;
use App\Schedule;
use App\Employee;

class PatientController extends Controller
{
    /**
     * Show the profile for the given patient.
     *
     * @param  int  $id
     * @param  Request $request
     * @return Response
     */
    public function get(Request $request, $patient_id = null)
    {
        if(isset($patient_id)){
            $patient = Patient::findOrFail($patient_id);
            $assigned_employees = [];
            if(isset($patient->employees)){
                $assigned_employees = $patient->employees;
            }
            $patient_data = [
                'patient' => $patient,
                'assigned_employees' => $assigned_employees,
                'employees' => Employee::orderBy('last_name')->get(),
            ];
            if($request->input('r') === 'true'){
                return view('patient', $patient_data);
            }else{
                return $patient_data;
            }
            
        }else{
            return Patient::orderBy('name')->get();
        }
    }

    public function store(Request $request)
    {
        $patient = Patient::create(array(
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name')
            ));
        
        return ['patient_id'=>$patient->id];
    }

    public function get_schedule(Request $request, $patient_id, $month=null)
    {
        if(isset($month)){
            return ['schedules' => Schedule::where('patient_id', $patient_id)]
                ->orderBy('date','asc')
                ->get();
        } else {
            $request->session()->flash('message', 'No results found!');
            $response = Response::make('No results found', 404);
                return $response->header('Content-Type', 'text/plain');
        }
    }

    public function assign_aide($patient_id, $employee_id, Request $request)
    {
        $patient = Patient::findOrFail($patient_id);
        $employee = Employee::findOrFail($employee_id);
        //Todo: only if attached is null
        $existing_employee = $patient->employees()->where('employee_id', $employee_id)->get();
        if(!count($existing_employee)){
            $patient->employees()->attach($employee_id);
        }
    }

    public function unassign_aide($patient_id, $employee_id)
    {
        $patient = Patient::findOrFail($patient_id);
        $employee = Employee::findOrFail($employee_id);        
        $patient->employees()->detach($employee_id);
    }
}
