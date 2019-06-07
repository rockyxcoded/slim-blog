<?php
namespace App\Controllers\Admin;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\PostCategory;
use App\Controllers\Controller;
use Respect\Validation\Validator as v;

class PostCategoryController extends Controller
{
	function index(Request $request, Response $response)
	{
		$categories = PostCategory::all();

		return $this->view->render($response, 'admin/post/category/all.twig', ['categories' => $categories]);
	}

	function show(Request $request, Response $response)
	{
		$category = PostsCategory::find($request->getParam('id'));

		return $this->view->render($response, 'admin/post/category/create.twig', ['category' => $category]);
	}


	function getCreate(Request $request, Response $response)
	{
		return $this->view->render($response, 'admin/post/category/create.twig');
	}

	public function postCreate(Request $request, Response $response) {

		$validation = $this->container->validator->validate($request, [
			'title' => v::notEmpty(),
		]);

		if ($validation->failed()) {
			return $response->withRedirect($this->router->pathFor('post.category.create'));
		}

		$title = $request->getParam('title');

		PostCategory::createFromRequest($requestuest);

		$this->container->flash->addMessage('success', 'category created successfully');

		return $response->withRedirect($this->router->pathFor('post.category.create'));
	}


	function getUpdate(Request $request, Response $response, Array $args)
	{
		$category = PostCategory::find($args['id']);

		return $this->view->render($response, 'admin/post/category/edit.twig', ['category' => $category]);
	}

	public function postUpdate(Request $request, Response $response, Array $args) {

		$id = $id = (int) $args['id'];

		$validation = $this->container->validator->validate($request, [
			'title' => v::notEmpty(),
			'slug' => v::notEmpty(),
		]);

		if ($validation->failed()) {
			return $response->withRedirect($this->router->pathFor('post.category.edit', ['id'=>$id]));
		}

		$title = $request->getParam('title');
		$slug = $request->getParam('slug');

		$create = PostCategory::where('id', $id )->update([
			'title' => $title,
			'slug' => str_slug($slug)
		]);

		$this->container->flash->addMessage( 'success', 'category updated successfully' );

		return $response->withRedirect($this->router->pathFor('post.categories'));
	}

	public function delete(Request $request, Response $response, Array $args) {

		$id = $id = (int) $args['id'];

		PostCategory::find($id)->delete();

		$this->container->flash->addMessage( 'success', 'Delete category request successfully' );

		return $response->withRedirect($this->router->pathFor('post.categories'));
	}
}