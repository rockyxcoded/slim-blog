<?php
namespace App\Controllers\Admin;

use App\Controllers\Controller;

class HomeController extends Controller
{
	function index($request, $response)
	{
		return $this->container->view->render($response, 'admin/home/home.twig');
	}
}