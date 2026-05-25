<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MeetGreetApplication extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $fillable = ['name', 'email', 'phone', 'organization', 'motivation', 'status', 'event'];
}
