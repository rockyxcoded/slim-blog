<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoCategory extends Model {

	protected $table = 'VideoCategory';
	
	protected $fillable = [
		'title', 'slug'
	];

	public function videos()
	{
		return static::hasMany(Video::class);
	}

	public function createFromRequest(Array $data) {

		return static::create($data);
	}
}
