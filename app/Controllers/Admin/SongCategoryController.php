<?php
namespace App\Controllers\Admin;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\SongCategory;
use App\Controllers\Controller;
use Respect\Validation\Validator as v;

class SongCategoryController extends Controller
{

	function index(Request $request, Response $response)
	{
		$categories =  SongCategory::all();

		return $this->view->render($response, 'admin/song/category/all.twig', ['categories' => $categories]);
	}

	function show(Request $request, Response $response)
	{
		$id = (int) $request->getParam('id');
		$category = SongCategory::find($id);

		return $this->view->render($response, 'song/category/create.twig', ['category' => $category]);
	}


	function getCreate(Request $request, Response $response)
	{
		return $this->view->render($response, 'admin/song/category/create.twig');
	}

	public function postCreate(Request $request, Response $response) {

		$validation = $this->container->validator->validate($request, [
			'title' => v::notEmpty()->songCategoryTitleExist(),
		]);

		if ($validation->failed()) {
			return $response->withRedirect($this->router->pathFor( 'song.category.create' ));
		}

		$title = $request->getParam('title');

		SongCategory::createFromRequest(['title' => $title, 'slug' => stri_slug($title)]);

		$this->container->flash->addMessage( 'success', 'Request was successfully' );

		return $response->withRedirect($this->router->pathFor('song.categories'));
	}


	function getUpdate(Request $request, Response $response, Array $args)
	{
		$id  = (int) $args['id'];
		$category = SongCategory::find($id);

		return $this->view->render($response, 'admin/song/category/edit.twig', ['category' => $category]);
	}

	public function postUpdate(Request $request, Response $response, Array $args) {

		$id = $id = (int) $args['id'];

		$validation = $this->container->validator->validate($request, [
			'title' => v::notEmpty()->songCategoryTitleExist(),
			'slug' => v::notEmpty()->songCategorySlugExist()
		]);

		if ($validation->failed()) {
			return $response->withRedirect($this->router->pathFor('song.category.edit', ['id'=>$id]));
		}

		//$id = (int) $args['id'];
		$title = $request->getParam('title');
		$slug = $request->getParam('slug');

		SongCategory::where('id', $id )->update([
			'title' => $title,
			'slug' => str_slug($slug)
		]);

		$this->container->flash->addMessage( 'success', 'create category request successfully' );

		return $response->withRedirect($this->router->pathFor('song.category.create'));
	}

	public function delete(Request $request, Response $response, Array $args) {

		$id = $id = (int) $args['id'];

		SongCategory::find($id)->delete();

		$this->container->flash->addMessage( 'success', 'Delete category request successfully' );

		return $response->withRedirect($this->router->pathFor('song.categories'));
	}
}
