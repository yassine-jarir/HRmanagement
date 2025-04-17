<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pointage extends Model
{
   protected $fillable = [
        'start_time',
        'end_time',
        'employee_id',
        'task_id',
    ];
    protected $table = 'pointage';

    public function users(){
        $this->belongsTo(User::class);
    }
    public function tasks(){
        $this->belongsTo(Tasks::class);
    }
}
