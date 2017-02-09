<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Timer extends Model
{
	public $table = 'timer';
	protected $fillable = [
		'count_down_date', 'count_down_time','status'
	];

}
