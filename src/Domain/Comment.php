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
     * Date of comment
     *
     * @var DateTime
     */
    protected $date_comment;

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

    /**
     *
     *@var integer
     */
    protected $signal;


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

    public function getDate_comment() {
        return $this->date_comment;
    }

    public function setDateComment($date){
        $this->date_comment = $date;
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

    public function getSignal()
    {
        return $this->signal;
    }

    public function setSignal($signal)
    {
        $this->signal = $signal;
        return $this;
    }


}