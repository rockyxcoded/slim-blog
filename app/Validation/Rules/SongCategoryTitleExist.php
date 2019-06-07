<?php
namespace App\Validation\Rules;

use App\Models\SongCategory;

use Respect\Validation\Rules\AbstractRule;

class SongCategoryTitleExist extends AbstractRule
{
	function validate($input)
	{
		return SongCategory::where('title', $input)->count() === 0;
	}
}