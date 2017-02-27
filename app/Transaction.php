<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
	protected $fillable = [
		'name',
		'amount',
	];

	public function account()
	{
		return $this->belongsTo('App\Account');
	}

	public function budget()
	{
		return $this->belongsTo('App\Transaction');
	}
}
