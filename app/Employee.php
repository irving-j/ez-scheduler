<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = array('last_name','first_name', 'initial', 'type', 'is_blocked', 'is_active', 'cutoff_date');

    /**
     * Get the timesheets for the employee.
     */
    public function timesheets()
    {
        return $this->hasMany('App\Timesheet');
    }

     /**
     * The patients assigned to the employee.
     */
    public function patients()
    {
        return $this->belongsToMany('App\Patient', 'employees_patients')->withTimestamps();
    }

    /**
     * The locations assigned to the employee.
     */
    public function locations()
    {
        return $this->belongsToMany('App\Location','employees_locations')->withTimestamps();
    }
}
