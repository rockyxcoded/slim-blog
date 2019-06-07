<?php

namespace App\Middleware;

class FlashMessageMiddleware extends Middleware
{
	public function __invoke($req, $res, $next) {

		//attaching Validation Errors to Twig
		$this->container->view->getEnvironment()->addGlobal('flash', $this->container->flash);
	
		return $next($req, $res);
	}
}	