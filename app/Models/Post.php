<?php 
namespace App\Models;

use App\Helpers\Session;

use Illuminate\Database\Eloquent\Model;

class Post extends Model {

	protected $table = 'Post';
	
	protected $fillable = [

		'title', 'user_id', 'content', 'views', 'slug', 'category_id', 'thumbnail'
	];

	public function category()
	{
		return $this->belongsTo(PostCategory::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function createFromRequest(array $data) {

		return self::create($data);
	}

	public function showByCategoryId($id)
	{
		$posts = self::where('category_id', $id)->get();

		return $posts;
	}
}
