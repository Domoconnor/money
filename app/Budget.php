<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
	protected $fillable = [
		'name',
		'amount'
	];

	public function user()
	{
		return $this->belongsTo('App\User');
	}

	public function transactions()
	{
		return $this->hasMany('App\Budget');
	}
}
