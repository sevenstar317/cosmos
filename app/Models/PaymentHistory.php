<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use \Validator;
use Illuminate\Support\Facades\Input;

class PaymentHistory extends Model
{
	protected $table ='payment_history';
	/**
	 * The attributes that are mass assignable.
	 *a
	 * @var array
	 */
	protected $fillable = [
		'user_id', 'member_id','lead_id', 'order_id', 'subtotal', 'total', 'discount', 'type'
	];

	public static $rules = array(
			'user_id' => 'required',
			'member_id'  => 'required',
			'lead_id'=>'required',
			'order_id'=>'required',
	);

	public function paymentInfo()
	{
		return $this->belongsTo('App\Models\PaymentInfo');
	}

	public static function saveHistory($user, $responce, $report = null){
		$paymentHistory = new self();
		$paymentHistory->user_id = $user->id;
		$paymentHistory->member_id = $user->member_id;
		$paymentHistory->lead_id = $user->lead_id;
		$paymentHistory->payment_info_id = $user->paymentInfo->id;
		$paymentHistory->type = $responce['type'];
		$paymentHistory->description = $responce['description'];
		$paymentHistory->total_minutes = $responce['totalMinutes'];
		$paymentHistory->order_id = $responce['order_id'];
		$paymentHistory->total = $responce['total'];
		$paymentHistory->subtotal = $responce['subtotal'];
		$paymentHistory->discount = $responce['discount'];
		$paymentHistory->report_id = isset($report)?$report->id:null;
		$paymentHistory->save();
		return $paymentHistory;
	}


}
