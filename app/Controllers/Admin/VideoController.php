<?php
namespace App\Controllers\Admin;

use App\Models\Video;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Helpers\Session;
use App\Models\VideoCategory;
use App\Controllers\Controller;
use Respect\Validation\Validator as v;

class VideoController extends Controller
{
	
	function index(Request $request, Response $response, $args)
	{
		$videos = Video::all();
		return $this->view->render($response, 'admin/video/home.twig', ['videos' => $videos]);
	}

	function show(Request $request, Response $response, $args)
	{
		$id = (int) $args['id'];
		$video = Video::find($id);

		return $this->view->render($response, 'video/show.twig', ['video' => $video]);
	}

	function getShowByCategoryId(Request $request, Response $response, $args)
	{
		$id = (int) $args['id'];
		$posts = Video::showByCategoryId($id);

		return $this->view->render($response, 'video/category.twig', ['posts' => $posts]);
	}

	function postShowByCategoryId(Request $request, Response $response, $args)
	{
		$slug = (string) $args['slug'];
		$post = Video::showByCategorySlug($slug);

		return $this->view->render($response, 'video/show.category.twig', ['post' => $post]);
	}


	function getCreate(Request $request, Response $response, $args)
	{
		$categories = videoCategory::all();
		return $this->view->render($response, 'admin/video/create.twig', ['categories' => $categories]);
	}

	public function postCreate(Request $request, Response $response, $args) 
	{
		$folder  = public_path('videos');

		$postValidation = $this->validator->validate($request, [
			'title' 	=> v::notEmpty()->videoTitleExist(),
			'category' 	=> v::notEmpty(),
			'content' 	=> v::notEmpty(),
			'thumbnail' => v::notEmpty(),
			'video' 	=> v::notEmpty(),
		]);

		if ($postValidation->failed()) {
			$this->container->flash->addMessage( 'error', 'Oops! An error occured');
			return $response->withRedirect($this->router->pathFor('video.create'));
		}

	    $thumbnail = $this->uploader->uploadVideoFromUrl(
	    	$request->getParam('thumbnail'), $folder, $request->getParam('title')
	    );
	    
	    $video = $this->uploader->uploadVideoFromUrl(
	    	$request->getParam('video'), $folder, $request->getParam('title')
	    );

	    if (!thumbnail || !$video) {
	    	$this->container->flash->addMessage( 'error', 'Request failed, check your network');
			return $response->withRedirect($this->router->pathFor('video.create'));
		}

		Video::createFromRequest([
			'uploaded_by' => 1,
			'title' => $request->getParam('title'),
			'thumbnail' => $thumbnail,
			'file' => $video,
			'slug' => str_slug($request->getParam('title')),
			'content' => $request->getParam('content'),
			'category' => $request->getParam('category'),
		]);

		$this->container->flash->addMessage( 'success', 'Request was successfully' );

		return $response->withRedirect( $this->router->pathFor('admin.videos') );
	}

	public function delete(Request $request, Response $response, Array $args) 
	{
		$id = $id = (int) $args['id'];

		Video::find($id)->delete();

		$this->container->flash->addMessage( 'success', 'Delete Video request successfully' );

		return $response->withRedirect($this->router->pathFor('admin.videos'));
	}
}
