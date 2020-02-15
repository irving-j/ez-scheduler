<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = array('last_name','first_name');
     /**
     * The employees assigned to the patient.
     */
    public function employees()
    {
        return $this->belongsToMany('App\Employee', 'employees_patients')->withTimestamps();
    }

    /**
     * Get the schedules for the patient.
     */
    public function schedules()
    {
        return $this->hasMany('App\Schedule')->withTimestamps();
    }
}
