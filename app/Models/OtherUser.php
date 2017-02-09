<?php

namespace App\Models;

use App\Helpers\Helper;
use App\Models\Agent;
use App\Models\Report;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class OtherUser extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name', 'email', 'password', 'city', 'state', 'new_password_confirmation','short_register','birth_time_hour','birth_time_minute','birth_time_type','birth_time_sunrise',
		'sign','sex','birth_day','birth_time','birth_month','birth_year','registration_token', 'lead_id','member_id', 's_c_city', 's_c_state','s_c_country',
			'new_password', 'old_password', 'zip', 'phone_number', 'address_1', 'first_name', 'last_name','real_password'
	];



	public $rules;

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
			'first_name' => 'required',
			'last_name'  => 'required',
			'birth_time_hour'=>'required',
			'birth_time_minute'=>'required',
			'birth_month'=>'required',
			'city'=>'required',
			'state'=>'required',
			's_c_city'=>'required',
			's_c_state'=>'required',
	);

	}

	public function getFullName()
	{
		return $this->first_name . ' ' . $this->last_name;
	}

	public function getBirthday()
	{
		return $this->monthNumber() . '/' . $this->birth_day . '/' . $this->birth_year;
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
