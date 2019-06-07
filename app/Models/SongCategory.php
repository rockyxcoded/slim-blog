<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SongCategory extends Model {

	protected $table = 'SongCategory';
	
	protected $fillable = [
		'title', 'slug'
	];

	public function songs()
	{
		return static::hasMany(Song::class);
	}

	public function createFromRequest(Array $data) {

		return static::create($data);
	}
}
