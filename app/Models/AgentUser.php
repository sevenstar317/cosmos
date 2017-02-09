<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Validator;
use Illuminate\Support\Facades\Input;

class AgentUser extends Model
{
	protected $table ='agent_user';
	/**
	 * The attributes that are mass assignable.
	 *a
	 * @var array
	 */
	protected $fillable = [
		'agent_id', 'user_id','agent_status', 'customer_status','chat_status', 'paid_for_email','paid_for_download'
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
			'chat_status' => 'required',
		);
	}

	public function agent()
	{
		return $this->hasOne('App\Models\Agent', 'id', 'agent_id');
	}

	public function client()
	{
		return $this->hasOne('App\User', 'id', 'user_id');
	}

	public function messages()
	{
		return $this->hasMany('App\Models\ChatMessage', 'chat_id', 'id');
	}

	protected static function boot()
	{
		static::creating(function ($model) {
			$model->chat_status = 'Draft';

			return $model->save();
		});
	}
}
