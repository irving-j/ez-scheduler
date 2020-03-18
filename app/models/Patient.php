<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = array('last_name','first_name');
     /**
     * The employees assigned to the patient.
     */
    public function employees()
    {
        return $this->belongsToMany('App\models\Employee', 'employees_patients')->withTimestamps();
    }

    /**
     * Get the schedules for the patient.
     */
    public function schedules()
    {
        return $this->hasMany('App\models\Schedule')->withTimestamps();
    }
}
