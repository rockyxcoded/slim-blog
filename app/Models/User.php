<?php 
namespace App\Models;

use App\Helpers\Hash;

use Illuminate\Database\Eloquent\Model;

class User extends Model {

	protected $table = 'User';
	
	protected $fillable = [
		'username', 'password', 'email', 
	];

	public function posts()
	{
		return $this->hasMany(Post::class);
	}

	public function songs()
	{
		return $this->hasMany(Song::class);
	}

	public function updatePassword($password) {

		return	$this->update([
			'password' => Hash::make($password),
		]);
	}

	public function createFromRequest($request) {

	}
}
