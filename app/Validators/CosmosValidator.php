<?php

namespace App\Validators;

use DB;
use Hash;
use Lang;
use Config;
use Validator;
/**
 * All weholi custom validators.
 */
class CosmosValidator extends \Illuminate\Validation\Validator
{
	/**
	 * @param $attribute
	 * @param $value
	 * @param $parameters
	 *
	 * @return bool
	 */
	public function validatePassword($attribute, $value, $parameters)
	{
		list($table, $id) = $parameters;
		$user = DB::table($table)->find($id);

		return Hash::check($value, $user->password);
	}


}
