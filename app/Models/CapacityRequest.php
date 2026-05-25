<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CapacityRequest extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'capacity',
        'survey_fee',
    ];
}
