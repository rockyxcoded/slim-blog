<?php

namespace App\Helpers;

class Config
{
	/**
	 * [$data description]
	 * @var [type]
	 */
	protected static $data;

	/**
	 * [load description]
	 * @param  array  $data [description]
	 * @return [type]       [description]
	 */
	public static function load(array $data )
	{
		self::$data = $data;
	}

	/**
	 * [get description]
	 * @param  [type] $path [description]
	 * @return [type]       [description]
	 */
	public static function get( $path )
	{
		$data = self::$data; 
		
		$parts = explode( '.', $path );

		foreach( $parts as $part ) {

			if(isset($data[$part])) {

				$data = $data[$part];	
			} 	
		}
		return $data;
	}
}