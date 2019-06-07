<?php
namespace App\Validation\Exceptions;

use Respect\Validation\Exceptions\ValidationException;

class SongCategoryTitleExistException extends ValidationException
{
	public static $defaultTemplates = [
		self::MODE_DEFAULT => [
			self::STANDARD => 'Category title already exists',
		]
	];
}