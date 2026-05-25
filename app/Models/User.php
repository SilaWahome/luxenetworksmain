<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'custom_id',
        'first_name',
        'second_name',
        'company_name',
        'phone_number',
        'mikrotics_count',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            $latestUser = static::orderBy('id', 'desc')->first();
            $nextId = $latestUser ? $latestUser->id + 1 : 1;
            $user->custom_id = 'LUX-' . str_pad($nextId, 3, '0', STR_PAD_LEFT);
            
            if (!$user->name) {
                $user->name = $user->first_name . ' ' . $user->second_name;
            }
        });
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
