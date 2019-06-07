<?php
use Slim\Http\Request;
use Slim\Http\Response;
use Respect\Validation\Validator as v;
use Illuminate\Database\Capsule\Manager;

// DIC configuration
$container = $app->getContainer();

$container['storagePath'] = dirname(__DIR__) . '/public/storage/';

// Adding eloquent
$capsule = new Manager;
$capsule->addConnection($container['settings']['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

// Adding eloquent to the container
$container['db'] = function ($c) use ($capsule) {
    return $capsule;
};

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};

// Register Twig View helper
$container['view'] = function ($c) {
    $settings = $c->get('settings')['renderer'];

    $view =  new Slim\Views\Twig($settings['template_path'], ['cache' => false]);

    //Instantiate and add Slim specific extension
    $view->addExtension(new \Slim\Views\TwigExtension($c->router, $c->request->getUri()));

    $view->getEnvironment()->addGlobal('postCategories', $c->PostCategoryController);

    $view->addExtension(new Twig_Extensions_Extension_Date());

    return $view;
};

$container['phpmp3'] = function ($c) {
    return new \App\Mp3Lib\PHP_Mp3Library();
};


$container['AdminHomeController'] = function ($c) {
    return new \App\Controllers\Admin\HomeController($c);
};
$container['AdminPostController'] = function ($c) {
    return new \App\Controllers\Admin\PostController($c);
};
$container['AdminSongController'] = function ($c) {
    return new \App\Controllers\Admin\SongController($c);
};
$container['AdminVideoController'] = function ($c) {
    return new \App\Controllers\Admin\VideoController($c);
};
$container['AdminPostCategoryController'] = function ($c) {
    return new \App\Controllers\Admin\PostCategoryController($c);
};
$container['AdminSongCategoryController'] = function ($c) {
    return new \App\Controllers\Admin\SongCategoryController($c);
};
$container['AdminVideoCategoryController'] = function ($c) {
    return new \App\Controllers\Admin\VideoCategoryController($c);
};



$container['HomeController'] = function ($c) {
    return new \App\Controllers\HomeController($c);
};
$container['AuthController'] = function ($c) {
    return new \App\Controllers\Auth\AuthController($c);
};
$container['PostController'] = function ($c) {
    return new \App\Controllers\PostController($c);
};
$container['PostCategoryController'] = function ($c) {
    return new \App\Controllers\PostCategoryController($c);
};
$container['SongController'] = function ($c) {
    return new \App\Controllers\SongController($c);
};
$container['SongCategoryController'] = function ($c) {
    return new \App\Controllers\SongCategoryController($c);
};
$container['VideoController'] = function ($c) {
    return new \App\Controllers\VideoController($c);
};
$container['VideoCategoryController'] = function ($c) {
    return new \App\Controllers\VideoCategoryController($c);
};


$container['validator'] = function ($c) {
    return new \App\Validation\validator;
};
$container['csrf'] = function ($c) {
    return new \Slim\Csrf\Guard;
};
$container['auth'] = function ($c) {
    return new \App\Authentication\Authentication;
};
$container['flash'] = function ($c) { return new \Slim\Flash\Messages; };
$container['uploader'] = function ($c) { return new \App\Helpers\FileUploader; };


v::with("App\\Validation\\Rules\\");