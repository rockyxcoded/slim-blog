<?php

namespace App\Validation\Rules;

use App\Models\User;
use Respect\Validation\Rules\AbstractRule;

/**
 * 
 */
class UsernameExist extends AbstractRule
{
	
	function validate($input)
	{
		return User::where('username', $input)->count() === 0;
	}
}