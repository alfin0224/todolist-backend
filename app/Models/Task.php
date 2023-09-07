<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['email', 'title', 'description', 'due_date', 'completed', 'reminder_status', 'reminder_date' ];

    protected $dates = ['due_date'];
}
