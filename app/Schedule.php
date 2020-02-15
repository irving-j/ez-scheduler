<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{

	protected $dates = [
		'created_at',
		'updated_at',
		'date'
	];
    /**
     * Get the patient for the schedule.
     */
    public function patient()
    {
        return $this->belongsTo('App\Patient')->withTimestamps();
    }

}
