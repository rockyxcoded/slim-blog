<?php

namespace App\Middleware;

class GuestMiddleware extends Middleware
{
	public function __invoke ($req, $res, $next)  {

		if ( !$this->container->auth->check() ) {
			$this->container->flash->addMessage( 'error', 'Access Denied' );
			return $res->withRedirect( $this->container->router->pathFor('auth.signin') );
		}
	
		return $next( $req, $res );
	}
}	