<?php

namespace App\Models;

 use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'address',
        'profile_picture',
        'date_of_birth',
        'department',
        'position',
        'hire_date',
        'profile_image',
    ];

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
    public function tasks(){
        return $this->belongsToMany(Tasks::class,'task_user','task_id', 'user_id');
    }
    public function payrolls(){
        return $this->hasMany(Payroll::class);
    }
    public function leaveReq(){
        return $this->hasMany(leaveReq::class);
    }
    public function pointages(){
        return $this->hasMany(Pointage::class);
    }
    public function notifications()
{
    return $this->morphMany(DatabaseNotification::class, 'notifiable');
}
}
