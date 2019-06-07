<?php
namespace App\Controllers;

class HomeController extends Controller
{
	function index($req, $res)
	{

		return $this->container->view->render($res, 'home.twig');
	}
}