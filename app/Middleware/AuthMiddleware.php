<?php

namespace App\Middleware;

class AuthMiddleware extends Middleware
{
	public function __invoke ($req, $res, $next)  {

		if ( $this->container->auth->check() ) {
			$this->container->flash->addMessage( 'error', 'Access denied' );
			return $res->withRedirect( $this->container->router->pathFor('home') );
		}
	
		return $next( $req, $res );
	}
}	