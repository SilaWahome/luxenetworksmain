<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MeetGreetAnnouncement extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $fillable = ['content', 'is_active'];
}
