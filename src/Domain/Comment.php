<?php

namespace OCBlog\Domain;

class Comment
{
    /**
     * Comment id.
     *
     * @var integer
     */
    protected $id;

    /**
     * Comment author.
     *
     * @var \OCBlog\Domain\User
     */
    protected $author;

    /**
     * Comment content.
     *
     * @var integer
     */
    protected $content;

    /**
     * Associated article.
     *
     * @var \OCBlog\Domain\Article
     */
    protected $article;

    /**
     *Id of parent comment
     *
     * @var integer
     */
    protected $parent_id;

    /**
     *
     *@var integer
     */
    protected $depth;



    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getAuthor() {
        return $this->author;
    }

    public function setAuthor(User $author) {
        $this->author = $author;
        return $this;
    }

    public function getContent() {
        return $this->content;
    }

    public function setContent($content) {
        $this->content = $content;
        return $this;
    }

    public function getArticle() {
        return $this->article;
    }

    public function setArticle(Article $article) {
        $this->article = $article;
        return $this;
    }

    public function getParentId()
    {
        return $this->parent_id;
    }

    public function setParentId($id)
    {
        $this->parent_id = $id;
        return $this;
    }

    public function getDepth()
    {
        return $this->depth;
    }

    public function setDepth($depth)
    {
        $this->depth = $depth;
        return $this;
    }


}