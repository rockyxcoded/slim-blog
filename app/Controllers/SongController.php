<?php
namespace App\Controllers;

use App\Models\Song;

use Slim\Http\Request;

use Slim\Http\Response;

use App\Helpers\Session;

use App\Models\SongCategory;

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
	
}
