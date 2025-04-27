<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class leaveReq extends Model
{
    protected $fillable = ['start_date', 'end_date' , 'leave_type', 'reason','emplyee_id', 'type'];
    protected $table = 'leave_request';
    public function user(){
        return $this->belongsTo(User::class,'emplyee_id','id');
    }
}
