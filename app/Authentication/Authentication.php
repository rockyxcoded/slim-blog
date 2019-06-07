<?php

namespace App\Authentication;

use App\Models\User;
use App\Helpers\Hash;
use App\Helpers\Session;

/**
 * 
 */
class Authentication
{
	public function user() {

		$user =  User::find(Session::get('userid'));

		return $user;
	}

	public function check() {
		return Session::has('userid');
	}

	public function attempt( $username , $password ) {

		$user = User::where('username', $username)->first();

		if ( !$user ) {
			return false;
		}
		
		if ( !Hash::verify( $password, $user->password ) ) {
			return false;
		}

		Session::put( 'userid', $user->id );

		return true;
	}

	public function signOut() {

		Session::delete( 'userid' );
	}
}