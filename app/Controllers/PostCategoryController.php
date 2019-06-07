<?php
namespace App\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\PostCategory;
use Respect\Validation\Validator as v;

class PostCategoryController extends Controller
{
	public function all() {

		$categories = PostCategory::all();

		return $categories;
	}

	function index(Request $request, Response $response)
	{
		$categories = $this->all();

		return $this->view->render($response, 'post/category/create.twig', ['categories' => $categories]);
	}

	function show(Request $request, Response $response)
	{
		$id = (int) $request->getParam( 'id' );

		$category = PostsCategory::find( $id );
		return $this->view->render($response, 'post/category/create.twig', ['category' => $category]);
	}
}