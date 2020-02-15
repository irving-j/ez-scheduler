<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
     /**
     * The recipients assigned to the message.
     */
    public function recipients()
    {
        return $this->belongsToMany('App\Employee', 'employees_messages')->withTimestamps();
    }
}
