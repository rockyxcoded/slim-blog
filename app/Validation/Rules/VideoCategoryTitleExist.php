<?php
namespace App\Validation\Rules;

use App\Models\VideoCategory;
use Respect\Validation\Rules\AbstractRule;

class VideoCategoryTitleExist extends AbstractRule
{
	function validate($input)
	{
		return VideoCategory::where('title', $input)->count() === 0;
	}
}