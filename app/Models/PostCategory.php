<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostCategory extends Model {

	protected $table = 'PostCategory';
	
	protected $fillable = [
		'title', 'slug'
	];

	public function posts()
	{
		return $this->hasMany(Post::class);
	}

	public function createFromRequest(Request $request) {

		$title = $request->getParam('title');

		return $this->create([
			'title' => $title,
			'slug' => str_slug($title)
		]);
	}
}
