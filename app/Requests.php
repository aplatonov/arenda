<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Requests extends Model
{
	protected $table = "requests";

	protected $fillable = ['request_name', 'comment', 'category_id', 'start_date', 'finish_date', 'owner_id', 'disabled', 'customer_id'];
	
	public function owner()
	{
		return $this->belongsTo('App\Users', 'owner_id', 'id');
	}	

	public function customer()
	{
		return $this->belongsTo('App\Users', 'customer_id', 'id');
	}

	public function category()
	{
		return $this->belongsTo('App\Categories', 'category_id', 'id');
	}	
}
