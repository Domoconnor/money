<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Account extends Model
{
    protected $fillable = [
    	'name'
	];

    public function getSum()
	{
		return $this->transactions()->get()->sum('amount');
	}
    public function transactions()
	{
    	return $this->hasMany('App\Transaction');
	}

	public function user()
	{
    	return $this->belongsTo('App\User');
	}
}
