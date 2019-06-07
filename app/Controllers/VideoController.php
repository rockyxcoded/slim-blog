<?php
namespace App\Controllers;

use App\Models\Video;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Helpers\Session;
use App\Models\SongCategory;
use App\Controllers\moveUploadedFile;
use Respect\Validation\Validator as v;

class VideoController extends Controller
{
	
	function index(Request $request, Response $response, $args)
	{
		$songs = Song::all();
		return $this->view->render($response, 'song/home.twig', ['songs' => $songs]);
	}

	function show(Request $request, Response $response, $args)
	{
		$id = (int) $args['id'];
		$video = Video::find($id);

		return $this->view->render($response, 'video/show.twig', ['video' => $video]);
	}
	
}
