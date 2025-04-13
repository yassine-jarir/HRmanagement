<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    protected $table = 'Tasks';
     protected $fillable = [
        'user_id',
        'task_name',
        'description',
        'status'
    ];
    public function users(){
        
        return $this->belongsToMany(User::class,'task_user','task_id', 'user_id');
    }
}
