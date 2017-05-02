<?php

// Return a list of all articles.

function getArticles (){
	$bdd = new PDO('mysql:host=localhost;dbname=OCblog;charset=utf8', 'ocblog_user', 'david');

	$articles = $bdd->query('SELECT * FROM article ORDER BY art_id DESC');
	return $articles;
}