<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
	protected $fillable = [
        'email', 'name', 'dopname', 'phone',
    ];

    public function customer()
    {
        return $this->hasMany('App\Objects', 'customer_id', 'id');
    }   
}
