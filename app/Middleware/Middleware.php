<?php
namespace App\Middleware;

Abstract class Middleware
{
	protected $container;

	function __construct($container)
	{
		$this->container = $container;
	}
}