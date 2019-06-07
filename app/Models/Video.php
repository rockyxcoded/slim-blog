<?php 
namespace App\Models;

use App\Helpers\Session;

use Illuminate\Database\Eloquent\Model;

class Video extends Model {

	protected $table = 'Video';
	
	protected $fillable = [

		'title', 'uploaded_by', 'content', 'views', 'slug', 'category', 'thumbnail', 'file'
	];

	public function category()
	{
		return $this->belongsTo(VideoCategory::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'uploaded_by');
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
