<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use \Validator;
use Illuminate\Support\Facades\Input;

class PaymentInfo extends Model
{
	protected $table ='payment_info';
	/**
	 * The attributes that are mass assignable.
	 *a
	 * @var array
	 */
	protected $fillable = [
		'card_name', 'card_number','user_id', 'card_month','card_year', 'card_cvv', 'zip'
	];

	public static $rules = array(
			'card_name' => 'required',
			'card_number'  => 'required',
			'card_month'=>'required',
			'card_year'=>'required',
			'card_cvv'=>'required',
			'zip'=>'required',
	);

}
