<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\models\Employee;
use App\models\Patient;
use App\models\User;
use App\models\Location;

class EmployeeController extends Controller
{
    /**
     * Show the profile for the given employee.
     *
     * @param  int      the employee id
     * @param  Request  $request
     * @return Response
     */
    public function get(Request $request, $id = null)
    {
        if(isset($id)){
            $employee = Employee::findOrFail($id);
            $assigned_patients = [];
            if(isset($employee->patients)){
                $assigned_patients = $employee->patients;
            }
            $assigned_locations = [];
            if(isset($employee->locations)){
                $assigned_locations = $employee->locations;
            }
            $user = User::where('employee_id', $id)->first();
            $employee_data = [
                'user' => $user,
                'employee' => $employee,
                'assigned_patients' => $assigned_patients,
                'assigned_locations' => $assigned_locations,
                'patients' => Patient::orderBy('last_name')->get(),
                'locations' => Location::orderBy('name')->get()
            ];
            if($request->input('r') === 'true'){
                return view('employee', $employee_data);
            }else{
                return $employee_data;
            }
            
        }else{
            return Employee::orderBy('last_name')->get();
        }
    }

    /**
     * Store a new employee.
     *
     * @param  Request  the $request containing the employee data
     * @return Response
     */
    public function store(Request $request)
    {
        $employee = Employee::create(array(
            'last_name' => $request->input('last_name'),
            'first_name' => $request->input('first_name'),
            'initial' => $request->input('initial'),
            'is_blocked' => false,
            'is_active' => true,
            'type' => $request->input('type')
        ));

        User::create(array(
            'name' => $request->input('username'),
            'password' => $request->input('password'),
            'email' => $request->input('username') . '@email.com',
            'employee_id' => $employee->id
        ));

        return ['employee_id'=>$employee->id];
    }

    public function update($id, Request $request)
    {
        $employee = Employee::find($id);
        $employee->last_name = $request->input('last_name');
        $employee->first_name = $request->input('first_name');
        $employee->initial = $request->input('initial');
        $employee->is_blocked = ($request->input('is_blocked') === "on") ? true : false;
        $employee->is_active = ($request->input('is_active') === "on") ? true : false;
        $employee->type = $request->input('type');
        $employee->cutoff_date = $request->input('urdate');
        $employee->save();

        $user = User::where('employee_id', $employee->id)->first();
        if(isset($user)){
            $user->name = $request->input('username');
            $user->password = $request->input('password');
            $user->save();
        }else{
            User::create(array(
                'name' => $request->input('username'),
                'password' => $request->input('password'),
                'email' => '',
                'employee_id' => $employee->id
            ));
        }
        
        return ['employee_id' => $employee->id];
    }

    public function delete($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();
    }

    public function assign_patient($id, $patient_id)
    {
        $employee = Employee::findOrFail($id);
        
        $existing_patient = $employee->patients()
            ->where('patient_id', $patient_id)
            ->get();

        if(!count($existing_patient)){
            $employee->patients()->attach($patient_id);
        }
    }

    public function assign_location($id, $location_id)
    {
        $employee = Employee::findOrFail($id);

        $existing_location = $employee->locations()
            ->where('location_id', $location_id)
            ->get();

        if(!count($existing_location)){
            $employee->locations()->attach($location_id);
        }    
    }

    public function remove_patient($employee_id, $patient_id)
    {
        $employee = Employee::findOrFail($employee_id);
        $employee->patients()->detach($patient_id); 
    }

    public function remove_location($employee_id, $location_id)
    {
        $employee = Employee::findOrFail($employee_id);
        $employee->locations()->detach($location_id);
    }
}
