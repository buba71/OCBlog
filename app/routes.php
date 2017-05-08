<?php

// Home page
$app->get('/', "OCBlog\Controller\HomeController::indexAction")
->bind('home');

// Detailed info about an article
$app->match('/article/{id}', "OCBlog\Controller\HomeController::articleAction")
->bind('article');

// Login form
$app->get('/login', "OCBlog\Controller\HomeController::loginAction")
->bind('login');

// Admin zone
$app->get('/admin', "OCBlog\Controller\AdminController::indexAction")
->bind('admin');

// Add a new article
$app->match('/admin/article/add', "OCBlog\Controller\AdminController::addArticleAction")
->bind('admin_article_add');

// Edit an existing article
$app->match('/admin/article/{id}/edit', "OCBlog\Controller\AdminController::editArticleAction")
->bind('admin_article_edit');

// Remove an article
$app->get('/admin/article/{id}/delete', "OCBlog\Controller\AdminController::deleteArticleAction")
->bind('admin_article_delete');

// Edit an existing comment
$app->match('/admin/comment/{id}/edit', "OCBlog\Controller\AdminController::editCommentAction")
->bind('admin_comment_edit');

// Remove a comment
$app->get('/admin/comment/{id}/delete', "OCBlog\Controller\AdminController::deleteCommentAction")
->bind('admin_comment_delete');

// Add a user
$app->match('/admin/user/add', "OCBlog\Controller\AdminController::addUserAction")
->bind('admin_user_add');

// Edit an existing user
$app->match('/admin/user/{id}/edit', "OCBlog\Controller\AdminController::editUserAction")
->bind('admin_user_edit');

// Remove a user
$app->get('/admin/user/{id}/delete', "OCBlog\Controller\AdminController::deleteUserAction")
->bind('admin_user_delete');

// API : get all articles
$app->get('/api/articles', "OCBlog\Controller\ApiController::getArticlesAction")
->bind('api_articles');

// API : get an article
$app->get('/api/article/{id}', "OCBlog\Controller\ApiController::getArticleAction")
->bind('api_article');

// API : create an article
$app->post('/api/article', "OCBlog\Controller\ApiController::addArticleAction")
->bind('api_article_add');

// API : remove an article
$app->delete('/api/article/{id}', "OCBlog\Controller\ApiController::deleteArticleAction")
->bind('api_article_delete');
