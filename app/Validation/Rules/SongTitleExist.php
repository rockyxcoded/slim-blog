<?php
namespace App\Validation\Rules;

use App\Models\Song;

use Respect\Validation\Rules\AbstractRule;

class SongTitleExist extends AbstractRule
{
	function validate($input)
	{
		return Song::where('title', $input)->count() === 0;
	}
}