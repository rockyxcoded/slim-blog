<?php

namespace App\Middleware;

use App\Helpers\Session;

class ValidationErrorsMiddleware extends Middleware
{
	public function __invoke($req, $res, $next) {

		//attaching Validation Errors to Twig
		$this->container->view->getEnvironment()->addGlobal('valErrors', Session::get('valErrors'));

		//killing the session
		Session::delete('valErrors');

		return $next($req, $res);
	}
}	