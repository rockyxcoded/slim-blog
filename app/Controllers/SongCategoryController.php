<?php
namespace App\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\SongCategory;
use Respect\Validation\Validator as v;

class SongCategoryController extends Controller
{

	function index(Request $request, Response $response)
	{
		$categories =  SongCategory::all();

		return $this->view->render($response, 'admin/song/category/create.twig', ['categories' => $categories]);
	}

	function show(Request $request, Response $response)
	{
		$id = (int) $request->getParam('id');
		$category = SongCategory::find($id);

		return $this->view->render($response, 'song/category/create.twig', ['category' => $category]);
	}

}
