<?php

namespace App\Middleware;

class ViewCsrfMiddleware extends Middleware
{
	public function __invoke($req, $res, $next) {

		//attaching Validation Errors to Twig
		$this->container->view->getEnvironment()->addGlobal('csrf', [
			'field' => "

				<div class='form-group'>
				<input type='hidden' name='{$this->container->csrf->getTokenNamekey()}' value='{$this->container->csrf->getTokenName()}' class='form-control'>
				</div>

				<div class='form-group'>
				<input type='hidden' name='{$this->container->csrf->getTokenValuekey()}' value='{$this->container->csrf->getTokenValue()}' class='form-control'>
				</div>
			"
		]);
	
		return $next($req, $res);
	}
}	