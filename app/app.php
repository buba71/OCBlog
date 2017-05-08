<?php

use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\ExceptionHandler;

// Register global error and exceptio hendlers
ErrorHandler::register();
ExceptionHandler::register();

// Register service providers.
$app->register(new Silex\Provider\DoctrineServiceProvider());
$app->register(new Silex\Provider\TwigServiceProvider(), array(
	'twig.path' => __DIR__.'/../views',
));



$app->register(new Silex\Provider\SessionServiceProvider());
$app->register(new Silex\Provider\SecurityServiceProvider(), array(
	'security.firewalls' => array(
		'secured' => array(
			'pattern' => '^/',
			'anonymous' => true,
			'logout' => true,
			'form' => array ('login_path' => '/login', 'check_path' => '/login_check'),
			'users' => function () use ($app) {
				return  new OCBlog\DAO\UserDAO($app['db']);
			},
		),
	),

));


// Register services.
$app['dao.article'] =function ($app) {
	return new OCBlog\DAO\ArticleDAO($app['db']);
};

$app['dao.user'] = function ($app) {
	return new OCBlog\DAO\UserDAO($app['db']);
};

$app['dao.comment'] = function ($app) {
    $commentDAO = new OCBlog\DAO\CommentDAO($app['db']);
    $commentDAO->setArticleDAO($app['dao.article']);
    $commentDAO->setUserDAO($app['dao.user']);
    return $commentDAO;
};