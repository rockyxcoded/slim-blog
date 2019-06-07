<?php
namespace App\Validation\Rules;

use App\Models\Video;
use Respect\Validation\Rules\AbstractRule;

class VideoTitleExist extends AbstractRule
{
	function validate($input)
	{
		return Video::where('title', $input)->count() === 0;
	}
}