<?php
namespace App\Validation\Exceptions;

use Respect\Validation\Exceptions\ValidationException;

class SongCategorySlugExistException extends ValidationException
{
	public static $defaultTemplates = [
		self::MODE_DEFAULT => [
			self::STANDARD => 'Category slug already exists',
		]
	];
}