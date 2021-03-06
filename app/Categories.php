<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    protected $table = "categories";
    public $fillable = ['name_cat', 'parent_id'];

    public function childs() {

        return $this->hasMany('App\Categories','parent_id','id') ;
    }

    public function parent() {

        return $this->hasOne('App\Categories','id','parent_id') ;
    }
	
	public function objects()
	{
		return $this->hasMany('App\Objects', 'category_id', 'id');
	}	    

	public function requests()
	{
		return $this->hasMany('App\Requests', 'category_id', 'id');
	}	
}
