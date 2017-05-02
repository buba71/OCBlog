<?php

namespace OCBlog\DAO;

use Doctrine\DBAL\Connection;
use OCBlog\Domain\Article;

class ArticleDAO
{

	/**
	 * Database connection
	 *
	 *  @var \Doctrine\DBAL\Conection
	 */
	 private $db;


	 /**
	  * Constructor
	  *
	  *@param \Doctrine\DBAL\Connection The database connection object
	  */
	 public function __construct(Connection $db)
	 {
	 	$this->db = $db;
	 }

	 /**
	  * Return a list of all articles.
	  *
	  * @return array of articles.
	  */
	 public function findAll()
	 {
	 	$sql = "SELECT * FROM t_article ORDER BY art_id DESC";
	 	$result = $this->db->fetchAll($$sql);
	 

	 // Convert query result to an array of domain objects.
	 $articles = array();
	 foreach ($result as $row)
	 {
	 	$articleId = $row['id'];
	 	$articles[$articleId] = $this->buildArticle($row);
	 }

	 return $articles;
	}

	/**
	 * Create an Article object based on a db row.
	 *
	 * @param array $row The db row containing Article data.
	 * @return \OCBlog\Domain\Article
	 */

	private function buildArticle(array $row)
	{
		$article = new Article();
		$article->setId($row['id']);
		$article->setTitle($row['title']);
		$article->setContent($row['content']);
		$article->setDate(new DateTime());

	}
}

