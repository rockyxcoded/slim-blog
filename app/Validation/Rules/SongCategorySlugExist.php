<?php
namespace App\Validation\Rules;

use App\Models\SongCategory;

use Respect\Validation\Rules\AbstractRule;

class SongCategorySlugExist extends AbstractRule
{
	function validate($input)
	{
		return SongCategory::where('slug', $input)->count() === 0;
	}
}