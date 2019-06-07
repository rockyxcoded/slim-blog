<?php
namespace App\Controllers\Admin;

use App\Models\Song;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Helpers\Session;
use App\Models\SongCategory;
use App\Controllers\Controller;
use App\Controllers\moveUploadedFile;
use Respect\Validation\Validator as v;

class SongController extends Controller
{
	
	function index(Request $request, Response $response, $args)
	{
		$songs = Song::all();
		return $this->view->render($response, 'song/home.twig', ['songs' => $songs]);
	}

	function show(Request $request, Response $response, $args)
	{
		$id = (int) $args['id'];
		$song = Song::find($id);

		return $this->view->render($response, 'song/show.twig', ['song' => $song]);
	}

	function getShowByCategoryId(Request $request, Response $response, $args)
	{
		$id = (int) $args['id'];

		$posts = Song::showByCategoryId($id);

		return $this->view->render($response, 'song/category.twig', ['posts' => $posts]);
	}

	function postShowByCategoryId(Request $request, Response $response, $args)
	{
		$slug = (string) $args['slug'];
		$post = Song::showByCategorySlug($slug);

		return $this->view->render($response, 'song/show.category.twig', ['post' => $post]);
	}


	function getCreate(Request $request, Response $response, $args)
	{
		$categories = SongCategory::all();
		return $this->view->render($response, 'admin/song/create.twig', ['categories' => $categories]);
	}

	public function postCreate(Request $request, Response $response, $args) {
		$validation = $this->validator->validate($request, [
			'title' 	=> v::notEmpty()->songTitleExist(),
			'category' 	=> v::notEmpty(),
			'content' 	=> v::notEmpty(),
			'thumbnail' => v::notEmpty(),
			'song' 		=> v::notEmpty(),
			'artiste' 		=> v::notEmpty()
		]);

		if ($validation->failed()) {
			return $response->withRedirect($this->router->pathFor('song.create'));
		}

	    //$thumbnail = $this->uploader->upload($this->container->storagePath . 'songs', $thumbnail);
	    
		$folder = storage_path('songs');

	    $songName = $this->uploader->uploadVideoFromUrl(
	    	$request->getParam('song'), $folder, $request->getParam('title')
	    );

	    if (!$songName) {
	    	$this->container->flash->addMessage( 'error', 'Request failed, check your network');
			return $response->withRedirect($this->router->pathFor('song.create'));
		}

	    $writeTags = $this->container->phpmp3->writeTags(
	    	$folder.$songName,
	    	$songName,
	    	$request->getParam('artiste'),
	    	'',
	    	'',
	    	'',
	    	'',
	    	''
	    );

	    if (!$writeTags) {
	    	$this->container->flash->addMessage( 'error', 'Unable to write Tags' );
			return $response->withRedirect( $this->router->pathFor('song.create') );
	    }

		Song::createFromRequest([
			'artiste' => $request->getParam('artist'),
			'uploaded_by' => 1,
			'title' => $request->getParam('title'),
			'thumbnail' => $thumbnail,
			'file' => $songName,
			'slug' => str_slug($request->getParam('title')),
			'content' => $request->getParam('content'),
			'category' => $request->getParam('category'),
		]);

		$this->container->flash->addMessage( 'success', 'Request was successfully' );

		return $response->withRedirect( $this->router->pathFor('song.create') );
	}

	public function delete(Request $request, Response $response, Array $args) {

		$id = $id = (int) $args['id'];

		Song::find($id)->delete();

		$this->container->flash->addMessage( 'success', 'Delete song request successfully' );

		return $response->withRedirect($this->router->pathFor('admin.songs'));
	}
}
