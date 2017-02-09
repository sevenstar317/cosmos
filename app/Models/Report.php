<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Validator;

class Report extends Model
{
	protected $table ='reports';
	/**
	 * The attributes that are mass assignable.
	 *a
	 * @var array
	 */
	protected $fillable = [
		'type', 'status','user_id', 'user_second_id', 'text'
	];

	public static $rules = array(
			'user_id' => 'required',
			'type'  => 'required',
	);

}
