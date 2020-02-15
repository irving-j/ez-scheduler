<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Location;
use App\Employee;

class LocationController extends Controller
{
    /**
     * Show the profile for the given location.
     *
     * @param  int  $id
     * @param  Request $request
     * @return Response
     */
    public function get(Request $request, $location_id = null)
    {
        
        if(isset($location_id)){
            $location = Location::findOrFail($location_id);
            $assigned_employees = [];
            if(isset($location->employees)){
                $assigned_employees = $location->employees;
            }
            $location_data = [
                'location' => $location,
                'assigned_employees' => $assigned_employees,
                'employees' => Employee::orderBy('last_name')->get(),
            ];
            if($request->input('r') === 'true'){
                return view('location', $location_data);
            }else{
                return $location_data;
            }
            
        }else{
            return Location::orderBy('name')->get();
        }

    }

    /**
     * Save the location
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        $location = Location::create(array(
            'name' => $request->input('location_name')
            ));
        
        return ['location_id'=>$location->id];
    }

    /**
     * Assign employee to the specified location
     *
     * @param int $id           the location id
     * @param int $employee_id  the employee id
     */
    public function assign_employee($location_id, $employee_id, Request $request)
    {
        $location = Location::findOrFail($location_id);
        $employee = Employee::findOrFail($employee_id);
        $existing_employee = $location->employees()->where('employee_id', $employee_id)->get();
        if(!count($existing_employee)){
            $location->employees()->attach($employee_id);
        }
               
    }

    public function remove_employee($location_id, $employee_id)
    {
        $location = Location::findOrFail($location_id);
        $employee = Employee::findOrFail($employee_id);        
        $employee->locations()->detach($location_id);
    }

}
