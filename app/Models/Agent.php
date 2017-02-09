<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Agent extends Authenticatable
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
		'name',
			'email',
			'password',
			'city',
			'state',
			'new_password_confirmation',
			'new_password',
			'old_password',
			'zip',
			'first_name',
			'last_name',
			'speciality_1',
			'speciality_2'
		,'speciality_3'
		,'speciality_4'
		,'speciality_5'
			,'image',
		'status'
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
			'email' => 'unique:agents,email,{id}|required',
		);
	}


	public function states()
	{
		return $this->hasOne('App\Models\States', 'state', 'state');
	}

	public function customers()
	{
		return $this->belongsToMany('App\User')->withPivot('chat_status');
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

}
