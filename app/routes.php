<?php
//$app->get('/[{name}]', 'HomeController:index')->setName('home');

$app->get('/', 'HomeController:index')->setName('home');

$app->get('/forum/category/{id}', 'PostController:getShowByCategoryId')->setName('post.show.category.id');

$app->get('/posts', 'PostController:index')->setName('posts');
$app->get('/post/{id}/{slug}', 'PostController:show')->setName('post.show');

$app->get('/songs', 'SongController:index')->setName('songs');
$app->get('/song/{id}/{slug}', 'SongController:show')->setName('song.show');

$app->get('/videos', 'VideoController:index')->setName('videos');
$app->get('/video/{id}/{slug}', 'VideoController:show')->setName('video.show');

$app->get('/user/{id}', 'User:show')->setName('user.profile');

$app->group('', function($app) {

	$app->get('/auth/signup', 'AuthController:getSignUp')->setName('auth.signup');
	$app->post('/auth/signup', 'AuthController:postSignUp');

	$app->get('/auth/signin', 'AuthController:getSignIn')->setName('auth.signin');
	$app->post('/auth/signin', 'AuthController:postSignIn');

	$app->get('/auth/password/reset', 'AuthController:getResetPassword')->setName('auth.password.reset');
	$app->post('/auth/password/reset', 'AuthController:postResetPassword');

})->add(new App\Middleware\AuthMiddleware($container));

$app->group('', function($app) {

	$app->get('/auth/password/change', 'AuthController:getChangePassword')->setName('auth.password.change');
	$app->post('/auth/password/change', 'AuthController:postChangePassword');
	$app->get('/auth/signout', 'AuthController:getSignOut')->setName('auth.signout');

	// $app->get('/post/create', 'PostController:getCreate')->setName('post.create');
	// $app->post('/post/create', 'PostController:postCreate');

})->add(new App\Middleware\GuestMiddleware($container));


$app->group('/admin', function($app){

	$app->get('', 'AdminHomeController:index')->setName('admin.home');

	$app->get('/songs', 'AdminPostController:index')->setName('admin.posts');
	$app->get('/song/create', 'AdminSongController:getCreate')->setName('song.create');
	$app->post('/song/create', 'AdminSongController:postCreate');
	$app->get('/song/{id}/edit', 'Admin/SongController:getUpdate')->setName('song.edit');
	$app->post('/song/{id}/edit', 'Admin/SongController:postUpdate');
	$app->get('/song/{id}/delete', 'Admin/SongController:delete')->setName('song.delete');

	$app->get('/posts', 'AdminPostController:index')->setName('admin.songs');
	$app->get('/post/create', 'AdminPostController:getCreate')->setName('post.create');
	$app->post('/post/create', 'AdminPostController:postCreate');
	$app->get('/post/{id}/edit', 'AdminPostController:getUpdate')->setName('post.edit');
	$app->post('/post/{id}/edit', 'AdminPostController:postUpdate');
	$app->get('/post/{id}/delete', 'AdminPostController:delete')->setName('post.delete');

	$app->get('/videos', 'AdminVideoController:index')->setName('admin.videos');
	$app->get('/video/create', 'AdminVideoController:getCreate')->setName('video.create');
	$app->post('/video/create', 'AdminVideoController:postCreate');
	$app->get('/video/{id}/edit', 'AdminVideoController:getUpdate')->setName('video.edit');
	$app->post('/video/{id}/edit', 'AdminVideoController:postUpdate');
	$app->get('/video/{id}/delete', 'AdminVideoController:delete')->setName('video.delete');

	$app->get('/post/categories', 'AdminPostCategoryController:index')->setName('post.categories');
	$app->get('/post/category/create', 'AdminPostCategoryController:getCreate')->setName('post.category.create');
	$app->post('/post/category/create', 'AdminPostCategoryController:postCreate');
	$app->get('/post/category/{id}/edit', 'AdminPostCategoryController:getUpdate')->setName('post.category.edit');
	$app->post('/post/category/{id}/edit', 'AdminPostCategoryController:postUpdate');
	$app->get('/post/category/{id}/delete', 'AdminPostCategoryController:delete')->setName('post.category.delete');

	$app->get('/song/categories', 'AdminSongCategoryController:index')->setName('song.categories');
	$app->get('/song/category/create', 'AdminSongCategoryController:getCreate')->setName('song.category.create');
	$app->post('/song/category/create', 'AdminSongCategoryController:postCreate');
	$app->get('/song/category/{id}/edit', 'AdminSongCategoryController:getUpdate')->setName('song.category.edit');
	$app->post('/song/category/{id}/edit', 'AdminSongCategoryController:postUpdate');
	$app->get('/song/category/{id}/delete', 'AdminSongCategoryController:delete')->setName('song.category.delete');

	$app->get('/video/categories', 'AdminVideoCategoryController:index')->setName('video.categories');
	$app->get('/video/category/create', 'AdminVideoCategoryController:getCreate')->setName('video.category.create');
	$app->post('/video/category/create', 'AdminVideoCategoryController:postCreate');
	$app->get('/video/category/{id}/edit', 'AdminVideoCategoryController:getUpdate')->setName('video.category.edit');
	$app->post('/video/category/{id}/edit', 'AdminVideoCategoryController:postUpdate');
$app->get('/video/category/{id}/delete', 'AdminVideoCategoryController:delete')->setName('video.category.delete');

});