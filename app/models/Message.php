<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
     /**
     * The recipients assigned to the message.
     */
    public function recipients()
    {
        return $this->belongsToMany('App\models\Employee', 'employees_messages')->withTimestamps();
    }
}
