<<<<<<< HEAD
<?php

use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\ExceptionHandler;
use Symfony\Component\HttpFoundation\Request;

// Register global error and exception handlers
ErrorHandler::register();
ExceptionHandler::register();

// Register service providers.
$app->register(new Silex\Provider\DoctrineServiceProvider());
$app->register(new Silex\Provider\TwigServiceProvider(), array(
	'twig.path' 	=> __DIR__.'/../views',
	'twig.options'  => array('debug' => true),
));
$app->register(new Silex\Provider\HttpFragmentServiceProvider());

$app->register(new Silex\Provider\AssetServiceProvider(), array(
	'asset.version' => 'v1'
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
	'security.role_hierarchy' => array(
		'ROLE_ADMIN' => array('ROLE_USER'),
	),
	'security.access_rules' => array(
		array('^/admin', 'ROLE_ADMIN'),
	),

));

$app['twig'] = $app->extend('twig', function(Twig_Environment $twig, $app) {
    $twig->addExtension(new Twig_Extensions_Extension_Text());
    return $twig;
});




$app->register(new Silex\Provider\ValidatorServiceProvider());
$app->register(new Silex\Provider\FormServiceProvider());
$app->register(new Silex\Provider\LocaleServiceProvider());
$app->register(new Silex\Provider\TranslationServiceProvider());


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

//Register error handler

$app->error(function(\Exception $e, Request $request, $code) use ($app){
	switch ($code){
		case 403:
			$message = 'Accès refusé.';
			break;
		case 404:
			$message = 'La ressource demandé n\'a pas été trouvée.';
			break;
		default:
			$message = 'Nous avons rencontré une erreur';
	}

	return $app['twig']->render('error.html.twig', array('message'=>
		$message));
});


=======
<?php
use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\ExceptionHandler;
use Symfony\Component\HttpFoundation\Request;

// Register global error and exception handlers
ErrorHandler::register();
ExceptionHandler::register();

// Register service providers.
$app->register(new Silex\Provider\DoctrineServiceProvider());
$app->register(new Silex\Provider\TwigServiceProvider(), array(
	'twig.path' 	=> __DIR__.'/../views',
	'twig.options'  => array('debug' => true),
));
$app->register(new Silex\Provider\HttpFragmentServiceProvider());

$app->register(new Silex\Provider\AssetServiceProvider(), array(
	'asset.version' => 'v1'
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
	'security.role_hierarchy' => array(
		'ROLE_ADMIN' => array('ROLE_USER'),
	),
	'security.access_rules' => array(
		array('^/admin', 'ROLE_ADMIN'),
	),

));

$app['twig'] = $app->extend('twig', function(Twig_Environment $twig, $app) {
    $twig->addExtension(new Twig_Extensions_Extension_Text());
    return $twig;
});




$app->register(new Silex\Provider\ValidatorServiceProvider());
$app->register(new Silex\Provider\FormServiceProvider());
$app->register(new Silex\Provider\LocaleServiceProvider());
$app->register(new Silex\Provider\TranslationServiceProvider());


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
>>>>>>> 3fb996bba6235fa2de5a316554b3192d3dd84d85
