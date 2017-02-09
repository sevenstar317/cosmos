<?php

namespace App;

use App\Helpers\Helper;
use App\Models\Agent;
use App\Models\Report;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
	public $old_password;
	public $new_password;
	public $new_password_confirmation;
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name', 'email', 'password', 'city', 'state', 'new_password_confirmation','short_register','c_city', 'c_state','c_country',
		'sign','sex','birth_day','birth_time','birth_month','birth_year','registration_token', 'lead_id','member_id','ip','lat','lan',
			'new_password', 'old_password', 'zip', 'phone_number', 'address_1', 'first_name', 'last_name','real_password'
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];

	public $rules;

	protected $appends = ['package'];

	/**
	 * Create a new Eloquent model instance.
	 *
	 * @param  array $attributes
	 * @return void
	 */
	public function __construct(array $attributes = [])
	{
		parent::__construct($attributes);

		$this->rules = array(
			'email' => 'unique:users,email,{id}|required',
		);

	}

	public function states()
	{
		return $this->hasOne('App\Models\States', 'state', 'state');
	}

	public function paymentInfo()
	{
		return $this->hasOne('App\Models\PaymentInfo');
	}

	public function paymentHistory()
	{
		return $this->hasMany('App\Models\PaymentHistory');
	}

	public function getNatalReport(){
		$report = Report::where('user_id', $this->id)->where('type','natal')->first();
		if($report){
			return $report;
		} else {
			return false;
		}
	}

	public function getFutureReport(){
		$report = Report::where('user_id', $this->id)->where('type','transit3')->first();
		if($report){
			return $report;
		} else {
			return false;
		}
	}

	public function getRomanticReport(){
		$report = Report::where('user_id', $this->id)->where('type','relationship')->first();
		if($report){
			return $report;
		} else {
			return false;
		}
	}

	public function agents()
	{
		return $this->belongsToMany('App\Models\Agent');
	}


	public function getFullName()
	{
		return $this->first_name . ' ' . $this->last_name;
	}

	public function getBirthday()
	{
		return $this->monthNumber() . '/' . $this->birth_day . '/' . $this->birth_year;
	}

	public function hisAgents(){
			return Agent::all();
	}

	public function getPackageAttribute(){
		$package = $this->paymentHistory->where('type','minutes')->last();
		if($package){
			return  $package->description;
		}else{
			return '1';
		}

	}

	/**
	 * Get the rules in use
	 *
	 * @param array $attributes
	 *
	 * @return array
	 */
	public function getRules(array $attributes = array())
	{
		$rules = $this->rules;
		if (!$this) {
			return $rules;
		}

		// Replace placeholders in rules
		foreach ($rules as $key => $rule) {
			preg_match_all('/\{([a-z_]+)\}/', $rule, $matches);
			foreach ($matches[1] as $attribute) {
				$rule = str_replace('{' . $attribute . '}', $this->$attribute, $rule);
			}

			$rules[$key] = $rule;
		}

		return $rules;
	}

	public function monthNumber()
	{
		return Helper::getMonthNumber($this->birth_month);
	}

	public function getAge()
	{

		$birthDate = $this->monthNumber() . '/' . $this->birth_day . '/' . $this->birth_year;
		//explode the date to get month, day and year
		$birthDate = explode("/", $birthDate);
		//get age from date or birthdate
		$age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md")
			? ((date("Y") - $birthDate[2]) - 1)
			: (date("Y") - $birthDate[2]));
		echo $age;
	}

}
