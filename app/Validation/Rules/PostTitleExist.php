<?php

namespace App\Validation\Rules;

use App\Models\Post;
use Respect\Validation\Rules\AbstractRule;

/**
 * 
 */
class PostTitleExist extends AbstractRule
{
	function validate($input)
	{
		return Post::where('title', $input)->count() === 0;
	}
}