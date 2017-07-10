<?php

namespace OCBlog\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use OCBlog\Domain\Comment;
use OCBlog\Form\Type\CommentType;
use Symfony\Component\Validator\Constraints\Date;


class HomeController {

    /**
     * Home page controller.
     *
     * @param Application $app Silex application
     */
    public function indexAction(Application $app) {
        $articles = $app['dao.article']->findAll();
        return $app['twig']->render('index.html.twig', array('articles' => $articles));
    }
    
    /**
     * Article details controller.
     *
     * @param integer $id Article id
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function articleAction($id, Request $request, Application $app) {

        $article = $app['dao.article']->find($id);
        $commentFormView = null;
        if(isset($_POST['commentContent']) && !empty($_POST['commentContent'])) {

        $content = $_POST['commentContent'];
        $parent_id = $_POST['parent_id'];



        $comment = new Comment();
        $date  = Date("Y-m-d");
        $comment->setDateComment($date);


        $comment->setArticle($article);
        $user = $app['dao.user']->find(3);
        
        

        $comment->setAuthor($user);
        $comment->setContent($content);

        $comment->setParentId($parent_id);

        $app['dao.comment']->save($comment);
        $app['session']->getFlashBag()->add('success', 'Votre commentaire a été publié.');

        }

        //}

        /**
         * Create an array of all comments with childrens
         *
         * @param $comments->findAllByArticle($id).
         */
        $comments = $app['dao.comment']->findAllByArticle($id);


        $comments_by_id=[];

        foreach ($comments as $comment)
        {
            $comments_by_id[$comment->getId()] = $comment;
        }
        foreach ($comments as $key => $comment) {
            if($comment->getParentId() != 0)
            {
                $comments_by_id[$comment->getParentId()]->childrens[]=$comment;
                unset($comments[$key]);
            }
       }

        return $app['twig']->render('article.html.twig', array(
            'article' => $article,
            'comments' => $comments,
            'commentForm' => $commentFormView
        ));




    }


    public function subCommentAction (Application $app)
    {
        $parent_id = $_GET['parent_id'];

        return $app['twig']->render('commentReply_form.html.twig', array(
            'parentId' => $parent_id
            ));
    }



    public function signalCommentAction (Application $app)
    {

        $comment = $_GET['id'];

        $app['dao.comment']->signalComment($comment);
        $app['session']->getFlashBag()->add('success', 'Commentaire signalé !');

        return $app['twig']->render('signalComment.html.twig');

    }
    /**
     * User login controller.
     *
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function loginAction(Request $request, Application $app) {
        return $app['twig']->render('login.html.twig', array(
            'error'         => $app['security.last_error']($request),
            'last_username' => $app['session']->get('_security.last_username'),
        ));
    }
}
