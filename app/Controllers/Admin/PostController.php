<?php
namespace App\Controllers\Admin;

use App\Models\Post;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Helpers\Session;
use App\Models\PostCategory;
use App\Controllers\Controller;
use App\Controllers\moveUploadedFile;
use Respect\Validation\Validator as v;

class PostController extends Controller
{
	
	function index(Request $request, Response $response, $args)
	{
		$posts = Post::all();
		return $this->view->render($response, '/admin/post/all.twig', ['posts' => $posts]);
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


	function getCreate(Request $request, Response $response)
	{
		$categories = $this->container->PostCategoryController->all();

		return $this->view->render($response, 'admin/post/create.twig', ['categories' => $categories]);
	}

	public function postCreate(Request $request, Response $response, $args) {

		$validation = $this->validator->validate($request, [
			'title' => v::notEmpty()->postTitleExist(),
			//'thumbnail' => v::image(),
			'content' => v::notEmpty(),
			'category' => v::notEmpty()
		]);

		if ($validation->failed()) {
			return $response->withRedirect($this->router->pathFor('post.create'));
		}

	    $filename = $this->uploader->upload(
	    	$this->container->storagePath,
	    	$request->getUploadedFiles()['thumbnail']
	    );

		Post::createFromRequest([
			'user_id' => Session::get('userid'),
			'title' => $request->getParam('title'),
			'thumbnail' => $filename,
			'slug' => str_slug($request->getParam('title')),
			'content' => $request->getParam('content'),
			'category_id' => $request->getParam('category'),
		]);

		$this->container->flash->addMessage( 'success', 'Topic created successfully' );

		return $response->withRedirect( $this->router->pathFor('post.create') );
	}

	public function delete(Request $request, Response $response, Array $args) {

		$id = $id = (int) $args['id'];

		Post::find($id)->delete();

		$this->container->flash->addMessage( 'success', 'Delete Post request successfully' );

		return $response->withRedirect($this->router->pathFor('admin.posts'));
	}
}
