<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Cities extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *a
	 * @var array
	 */
	protected $fillable = [
		'city', 'state_code',
	];


}
