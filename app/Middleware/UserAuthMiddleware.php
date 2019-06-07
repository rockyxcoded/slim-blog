<?php

namespace App\Middleware;

use App\Helpers\Session;

class UserAuthMiddleware extends Middleware
{
	public function __invoke($req, $res, $next) {

		$this->container->view->getEnvironment()->addGlobal('auth', [
			'check' => $this->container->auth->check(),
			'user' => $this->container->auth->user()
		]);

		return $next($req, $res);
	}
}	