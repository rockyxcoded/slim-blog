<?php
namespace App\Controllers;

use App\Models\Post;

use Slim\Http\Request;

use Slim\Http\Response;

use App\Helpers\Session;

use App\Models\PostCategory;

use App\Controllers\moveUploadedFile;

use Respect\Validation\Validator as v;

class PostController extends Controller
{
	
	function index(Request $request, Response $response, $args)
	{
		$posts = Post::all();
		return $this->view->render($response, 'post/home.twig', ['posts' => $posts]);
	}

	function show(Request $request, Response $response, $args)
	{
		$id = (int) $args['id'];
		$post = Post::find($id);

		return $this->view->render($response, 'post/show.twig', ['post' => $post]);
	}

	function getShowByCategoryId(Request $request, Response $response, $args)
	{
		$id = (int) $args['id'];

		$posts = Post::showByCategoryId($id);

		return $this->view->render($response, 'post/category.twig', ['posts' => $posts]);
	}

	function postShowByCategoryId(Request $request, Response $response, $args)
	{
		$slug = (string) $args['slug'];

		$post = Post::showByCategorySlug($slug);

		return $this->view->render($response, 'post/show.category.twig', ['post' => $post]);
	}
}
