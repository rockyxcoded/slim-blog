<?php 

namespace App\Helpers;

class Database
{
	
	public function __construct()
	{
		$options = [ PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ];

		try {
			return new PDO( 'mysql:host=' . Config::get('db.host') . '; dbname=' . Config::get('db.name'), Config::get('db.username'), Config::get('db.password'), $options);
		} catch (PDOException $error) {
			die('Error: ' . $error->getMessage() );
		}
	}
}







