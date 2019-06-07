<?php
// Application middleware

//$app->add(new Slim\Csrf\Guard);

$app->add(new App\Middleware\ValidationErrorsMiddleware($container));

$app->add(new App\Middleware\OldInputMiddleware($container));

$app->add(new App\Middleware\ViewCsrfMiddleware($container));

$app->add(new App\Middleware\UserAuthMiddleware($container));

$app->add(new App\Middleware\FlashMessageMiddleware($container));