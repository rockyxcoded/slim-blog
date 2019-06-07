<?php
namespace App\Controllers\Auth;

use App\Models\User;
use App\Helpers\Hash;
use App\Controllers\Controller;
use Respect\Validation\Validator as v;

class AuthController extends Controller
{
	function getSignUp($req, $res)
	{
		return $this->container->view->render($res, 'auth/signup.twig');
	}

	function postSignUp($req, $res)
	{
		$validation = $this->validator->validate($req, [
			'username' => v::stringType()->notEmpty()->noWhitespace()->usernameExist(),
			'email' => v::notEmpty()->noWhitespace()->email()->emailExist(),
			'password' => v::notEmpty(),
		]);

		if ($validation->failed()) {
			return $res->withRedirect($this->router->pathFor('auth.signup'));
		}

		$user = User::create([
			'username' => $req->getparam('username'),
			'email' => $req->getparam('email'),
			'password' => Hash::make($req->getparam('password')),
		]);

		$this->container->flash->addMessage( 'success', 'Registration successful, Login below' );
		return $res->withRedirect($this->router->pathFor('auth.signin'));
	}

	function getSignIn($req, $res)
	{
		return $this->container->view->render($res, 'auth/signin.twig');
	}

	function postSignIn($req, $res)
	{
		$validation = $this->validator->validate($req, [
			'username' => v::stringType()->notEmpty()->noWhitespace(),
			'password' => v::notEmpty(),
		]);

		if ($validation->failed()) {
			return $res->withRedirect($this->router->pathFor('auth.signin'));
		}

		$auth = $this->container->auth->attempt( $req->getparam('username'), $req->getparam('password') );

		if ( !$auth ) {
			$this->container->flash->addMessage( 'error', 'ERROR: Invalid details, check & try again' );
			return $res->withRedirect( $this->router->pathFor( 'auth.signin' ) );
		}

		return $res->withRedirect($this->router->pathFor( 'home' ));
	}

	public function getSignOut($req, $res, $args) {

		$this->container->auth->signOut();
		$this->container->flash->addMessage( 'info', 'Thankss for coming, We look forward to seeing you again' );
		return $res->withRedirect( $this->router->pathFor('home') );
	}

	function getChangePassword($req, $res)
	{
		return $this->container->view->render($res, 'auth/password/change.twig');
	}

	function postChangePassword($req, $res, $args)
	{
		$validation = $this->validator->validate($req, [
			'password_old' => v::notEmpty()->matchesPassword($this->container->auth->user()->password),
			'password_new' => v::stringType()->notEmpty()->noWhitespace(),
		]);

		if ($validation->failed()) {
			return $res->withRedirect($this->router->pathFor(
				'auth.password.change'
			));
		}

		$this->container->auth->user()->updatePassword($req->getParam( 'password_new' ));

		$this->container->flash->addMessage( 'success', 'Passsword changed successfully' );

		return $res->withRedirect($this->router->pathFor( 'auth.password.change' ));
	}

	function getResetPassword($req, $res)
	{
		return $this->container->view->render($res, 'auth/password/reset.twig');
	}

	function postResetPassword($req, $res, $args)
	{
		$validation = $this->validator->validate($req, [
			'email' => v::notEmpty()->email()->emailNotExist()
		]);

		if ($validation->failed()) {
			return $res->withRedirect(
				$this->router->pathFor('auth.password.reset')
			);
		}

		$this->container->flash->addMessage( 
			'success', 'Passsword reset instructions has been sent to your email' 
		);

		return $res->withRedirect(
			$this->router->pathFor( 'auth.password.reset' )
		);
	}


}