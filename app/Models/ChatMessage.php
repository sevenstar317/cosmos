<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class ChatMessage extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'message', 'sender_id', 'chat_id', 'status',
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
				'sender_id' => 'required',
				'chat_id' => 'required',
		);
	}


	public function chat()
	{
		return $this->hasOne('App\Models\AgentUser', 'id', 'chat_id');
	}

	public function senderAgent()
	{
		return $this->hasOne('App\Models\Agent', 'id', 'sender_id');
	}

	public function senderClient()
	{
		return $this->hasOne('App\User', 'id', 'sender_id');
	}



}
