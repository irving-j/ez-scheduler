<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Timesheet extends Model
{
	/**
     * Get the employee for the timesheet.
     */
    public function employee()
    {
        return $this->belongsTo('App\Employee')->withTimestamps();
    }

    /**
     * Aggregate the timesheet totals for the date and options given
     */
    public function aggregate()
    {
    	// perform aggregation
    }
}
