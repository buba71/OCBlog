<?php

// Homme page.

$app->get('/', function() use ($app) {
	$articles = $app['dao.article']->findAll();

	ob_start();						// Start buffering HTML
	require '../views/view.php';
	$view = ob_get_clean();			// Assign HTML output to view
	return $view;
});