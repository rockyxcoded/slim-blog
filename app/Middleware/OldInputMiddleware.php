<?php

namespace App\Middleware;

use App\Helpers\Session;

class OldInputMiddleware extends Middleware
{
	public function __invoke($req, $res, $next) {

		//attaching All old inputs to Twig
		$this->container->view->getEnvironment()->addGlobal('old', Session::get('old'));

		//adding old input to the session
		Session::put('old', $req->getParams());

		return $next($req, $res);
	}
}	