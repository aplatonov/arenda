<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Objects extends Model
{
	protected $table = "objects";

	protected $fillable = ['object_name', 'description', 'category_id', 'year', 'images', 'owner_id', 'min_period', 'name_period', 'disabled', 'price', 'free_since', 'customer_id'];
	
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
