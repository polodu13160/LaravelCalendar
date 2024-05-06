<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
    use HasFactory;

    protected $fillable = [
        'start', 
        'end', 
        'title', 
        'description', 
        'is_all_day', 
        'visibility', 
        'user_id', 
        'event_id', 
        'backgroundColor', 
        'borderColor',
    ];
}
