<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    protected $table = 'Payroll';
  public  $fillable = [
        'user_id',
        'payment_date',
        'hours_worked',
        'salary'
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }

}
