<?php

namespace OCBlog\DAO;

use OCBlog\Domain\Comment;

class CommentDAO extends DAO
{
    /**
     * @var \OCBlog\DAO\ArticleDAO
     */
    private $articleDAO;

    /**
     *
     * @var \OCBlog\DAO\UserDAO
     */
    private $userDAO;

    public function setArticleDAO(ArticleDAO $articleDAO) {
        $this->articleDAO = $articleDAO;
    }

    public function setUserDAO(UserDAO $userDAO)
    {
        $this->userDAO = $userDAO;

    }

    /**
     * Return a list of all comments for an article, sorted by date (most recent last).
     *
     * @param integer $articleId The article id.
     *
     * @return array A list of all comments for the article.
     */
    public function findAllByArticle($articleId) {
        // The associated article is retrieved only once
        $article = $this->articleDAO->find($articleId);

        // art_id is not selected by the SQL query
        // The article won't be retrieved during domain objet construction
        $sql = "SELECT com_id, com_content, parent_id, DATE_FORMAT(date_comment, '%d/%m/%Y') AS date_comment, usr_id, depth, sign from comment where art_id=? order by com_id";
        $result = $this->getDb()->fetchAll($sql, array($articleId));

        // Convert query result to an array of domain objects
        $comments = array();
        foreach ($result as $row) {
            $comId = $row['com_id'];
            $comment = $this->buildDomainObject($row);
            // The associated article is defined for the constructed comment
            $comment->setArticle($article);
            $comments[$comId] = $comment;

        }


        return $comments;
    }

     /**
     * Returns a list of all comments, sorted by date (most recent first).
     *
     * @return array A list of all comments.
     */
    public function findAll() {
        $sql = "SELECT * FROM comment ORDER BY sign DESC";
        $result = $this->getDb()->fetchAll($sql);

        // Convert query result to an array of domain objects
        $entities = array();
        foreach ($result as $row) {
            $id = $row['com_id'];
            $entities[$id] = $this->buildDomainObject($row);
        }
        return $entities;
    }

    /**
     * Returns a comment matching the supplied id.
     *
     * @param integer $id The comment id
     *
     * @return \MicroCMS\Domain\Comment|throws an exception if no matching comment is found
     */
    public function find($id) {
        $sql = "SELECT * from comment where com_id=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No comment matching id " . $id);
    }

    /**
     * Saves a comment into the database.
     *
     * @param \OCBlog\Domain\Comment Comment to save
     */

    public function save(Comment $comment){
        $parent_id = isset($_POST['parent_id']) ? $_POST['parent_id'] : 0 ;
        $depth = 0;

        if($parent_id !==0)
            {
                $sql = "SELECT com_id, depth FROM comment WHERE com_id = ?";
                $com = $this->getDb()->fetchArray($sql, array($parent_id));

               /** if ($com == false)
                {
                    throw new \Exception('Le parent_id n\'éxiste pas !');
                }*/

                $depth = $com['1'] + 1;

            }

            $commentData = array(
                'art_id' => $comment->getArticle()->getId(),
                'usr_id' => $comment->getAuthor()->getId(),
                'com_content' => $comment->getContent(),
                'date_comment' => $comment-> getDate_comment(),
                'parent_id' => $comment->getParentId(),
                'depth' => $depth
            );




            if ($depth >3)
            {
                echo " vous ne pouvez pas répondre à ce commentaire";
            }
            else
            {
                if ($comment->getId())
                    {
                        //The comment exist->update.
                        $this->getDb()->update('comment', $commentData, array('com_id' => $comment->getId()));
                    }
                    else
                    {
                        //The comment has never been saved -> insert it
                        $this->getDb()->insert('comment', $commentData);
                        // Get the id of the newly created comment and set it on the object.
                        $id = $this->getDb()->lastInsertId();
                        $comment->setId($id);

                    }


            }

    }


    public function signalComment($id) {


        $sql = "SELECT sign FROM comment WHERE com_id= ?";
        $signalComment = $this->getDb()->fetchArray($sql, array($id));


        $signal = $signalComment['0'] + 1;

        $this->getDB()->update('comment', array('sign'=>$signal), array('com_id'=>$id));
    }




    public function delete($id) {

        // récupère le commentaire to delete
        $sql ="SELECT * FROM comment WHERE com_id= ? ";
        $deleteCom = $this->getDb()->fetchAll($sql, array($id));


        // Delete the comment
        $this->getDb()->delete('comment', array('com_id' => $id));

        //$this->getDb()->update('comment', array('parent_id' => $deleteCom->getParentId()), array('parent_id' => $deleteCom->getId()));
    }

     /**
     * Removes all comments for an article
     *
     * @param $articleId The id of the article
     */
    public function deleteAllByArticle($articleId) {
        $this->getDb()->delete('comment', array('art_id' => $articleId));
    }

     /**
     * Removes all comments for a user
     *
     * @param integer $userId The id of the user
     */
    public function deleteAllByUser($userId) {
        $this->getDb()->delete('comment', array('usr_id' => $userId));
    }

    /**
     * Creates an Comment object based on a DB row.
     *
     * @param array $row The DB row containing Comment data.
     * @return \OCBlog\Domain\Comment
     */
    protected function buildDomainObject(array $row) {
        $comment = new Comment();
        $comment->setId($row['com_id']);
        $comment->setContent($row['com_content']);

        $comment->setDateComment($row['date_comment']);
        $comment->setParentId($row['parent_id']);
        $comment->setDepth($row['depth']);
        $comment->setSignal($row['sign']);


        if (array_key_exists('art_id', $row)) {
            // Find and set the associated article
            $articleId = $row['art_id'];
            $article = $this->articleDAO->find($articleId);
            $comment->setArticle($article);
        }

        if (array_key_exists('usr_id', $row)) {
            // Find and set the associated author
            $userId =$row['usr_id'];
            $user =$this->userDAO->find($userId);
            $comment->setAuthor($user);
        }
        
        return $comment;
    }
}