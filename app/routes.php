<?php

// Homme page.

$app->get('/', function() {
	require '../src/model.php';
	$articles = getArticles();

	ob_start();						// Start buffering HTML
	require '../views/view.php';
	$view = ob_get_clean();			// Assign HTML output to view
	return $view;
});