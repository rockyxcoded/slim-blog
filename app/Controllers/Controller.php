<?php

namespace App\Controllers;

use Psr\Container\ContainerInterface;

Abstract class Controller
{
	protected $container;

	function __construct(ContainerInterface $container)
	{
		$this->container = $container;
	}

	function __get($property)
	{
		if ($this->container->{$property}) {
			return $this->container->{$property};
		}
	}
}