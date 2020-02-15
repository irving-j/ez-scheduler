<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
	protected $fillable = array('name');
     /**
     * The employees assigned to the location.
     */
    public function employees()
    {
        return $this->belongsToMany('App\Employee', 'employees_locations')->withTimestamps();
    }
}
