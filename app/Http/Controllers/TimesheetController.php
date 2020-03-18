<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\models\Timesheet; 
use App\models\Employee;
use App\models\Schedule;
use App\models\Patient;
use DateTime;
class TimesheetController extends Controller
{

    /**
     * Generate a weekly total based on end_date.
     *
     * @param  Request   $request
     * @return Response
     */
    public function report(Request $request)
    {
        if($request->has('end_date')){
            $end_date = $request->input('end_date');
            $timesheets = Timesheet::where('date','>',$end_date)->get();
            if(count($timesheets)){
                return view('timesheet_report',
                ['totals' =>  $timesheets]);
            }else{
                $request->session()->flash('message', 'No results found!');
                //Session::flash('', ''); 
                return view('timesheet_report');
            }
            
        }else{
            return view('timesheet_report');
        }
    }

    /**
     * Display the timesheets for the given employee and date ranges.
     *
     * @param  Request  $request
     * @return Response
     */
    public function search(Request $request)
    {
        if($request->has('start_date') && $request->has('end_date')){
            $start_date = $request->input('start_date');
            $end_date = $request->input('end_date');
            $timesheets = Timesheet::where([
                    [ 'employee_id', '=', $request->input('employee_id')],
                    [ 'date', '>', $start_date],
                    [ 'date', '<', $end_date]
                ]
            )->get();
            if(count($timesheets)){
                return view('timesheet_view',
                ['timesheets' =>  $timesheets]);
            }else{
                $request->session()->flash('message', 'No results found!');
                return response('No results found', 404)
                  ->header('Content-Type', 'text/plain');
            }
        }
    }

    /**
     * Show the timesheet for the given id.
     *
     * @param  int  $id
     * @return Response
     */
    public function get(Request $request, $id = null)
    {
        if(isset($id)){
            $timesheet = Timesheet::find($id);
            if(isset($timesheet)){
                return view('timesheet', ['timesheet' => $timesheet]);
            }else{
                $request->session()->flash('message', 'No results found!');
                return response('No results found', 404)
                  ->header('Content-Type', 'text/plain');
            }
        } else {
            return view('timesheet');
        }
    }

    /**
     * Show the timesheet for the given id.
     *
     * @param  int  $id
     * @return Response
     */
    public function getSubmittedTimesheets(Request $request)
    {
        
        $employeeId=10;
        $employee = Employee::find($employeeId);
        $cutoffDate = $employee->cutoff_date;
        $patientId = $request->input('patient_id');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
 

        $format = 'm-d-Y';
        
        $startDate = DateTime::createFromFormat($format, $startDate);
        $endDate = DateTime::createFromFormat($format, $endDate);
        //echo $startDate->format('Y-m-d');exit(1);

        return view('timesheet_edit', 
            [
                'patient' => Patient::find($patientId),
                'timecards' => Timesheet::where('employee_id', $employeeId)
                ->where('patient_id', $patientId)
                ->whereBetween('date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])->get()
            ]
        );
        
    }

    /**
     * Show the timesheet for the given patient_id and date.
     *
     * @param  int  $patient_id
     * @param  date $date
     * @return Response
     */
    public function by_patient_date($patient_id, $date)
    {
        return view('timesheet.timesheet', ['timesheet' => Timesheet::where([['patient_id', $patient_id],['date','>=','$date']]).get()]);
    }

	/**
     * Show the timesheet for the given employee_id and date.
     *
     * @param  int  $employee_id
     * @param  date date
     * @return Response
     */
    public function by_employee_date($employee_id, $date)
    {
        return view('timesheet.timesheet', ['timesheet' => Timesheet::where([['employee_id', $patient_id],['date','>=','$date']]).get()]);
    }

    //TODO:save timesheet

    public function store(Request $request)
    {
        $employeeId=10;
        $timesheet = new Timesheet;
        $timesheet->date = $request->input('date');
        $timesheet->time_in = $request->input('time_in');
        $timesheet->time_out = $request->input('time_out');
        $timesheet->employee_id = $employeeId;
        $timesheet->patient_id = $request->input('patient_id');
        //$timesheet->employee_id = $request->input('employee_id');
        //$timesheet->total = $time_out - $time_in
        $timesheet->save();
    }

    public function update(Request $request, $id)
    {
        $employeeId=10;

        $format = 'D M d,Y';
        
        $date = DateTime::createFromFormat($format, $request->input('date'));

        $timesheet = Timesheet::find($id);
        $timesheet->date = $date->format('Y-m-d');
        $timesheet->time_in = $request->input('time_in');
        $timesheet->time_out = $request->input('time_out');
        $timesheet->employee_id = $employeeId;
        $timesheet->patient_id = $request->input('patient_id');
        //$timesheet->employee_id = $request->input('employee_id');
        //$timesheet->total = $time_out - $time_in
        $timesheet->save();
    }

    public function delete(Request $request, $id)
    {
        $employeeId=10;
        $timesheet = Timesheet::find($id);
        $timesheet->delete();
    }

    /**
     * Render timecards for the selected patient
     *
     * @param Request $request
     * @param int $patient_id
     * @Return Response
     */
    public function getTimeCards(Request $request, $id) {
        $employeeId=10;
        $employee = Employee::find($employeeId);
        $cutoffDate = $employee->cutoff_date;
        return view('timesheet', 
            [
                'patient' => Patient::find($id),
                'schedules' => Schedule::where(
                    [
                        ['patient_id', $id],
                        ['date','>',$cutoffDate],
                        ['date','<=', date('Y-m-d').' 00:00:00']
                    ]
                )->get()
            ]
        );
    }
}
