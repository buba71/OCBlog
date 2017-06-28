<?php

namespace OCBlog\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use OCBlog\Domain\Comment;
use OCBlog\Form\Type\CommentType;

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



        if ($app['security.authorization_checker']->isGranted('IS_AUTHENTICATED_FULLY')) {
            // A user is fully authenticated : he can add comments
            $comment = new Comment();
            $comment->setArticle($article);
            $user = $app['user'];
            $comment->setAuthor($user);
            $commentForm = $app['form.factory']->create(CommentType::class, $comment);
            $commentForm->handleRequest($request);
            if ($commentForm->isSubmitted() && $commentForm->isValid()) {
                $app['dao.comment']->save($comment);
                $app['session']->getFlashBag()->add('success', 'Your comment was successfully added.');
            }


            $commentFormView = $commentForm->createView();



        }

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

    public function subCommentAction (Request $request, Application $app)
    {
        $subCommentFormview = null;
        $parentId = $_GET['parent_id'];

        echo $parentId;

        if ($app['security.authorization_checker']->isGranted('IS_AUTHENTICATED_FULLY')) {
            // A user is fully authenticated : he can add comments
            $comment = new Comment();
            //$comment->setArticle($article);
            $user = $app['user'];
            $comment->setAuthor($user);


            $subCommentForm = $app['form.factory']->create(CommentType::class, $comment);
            $subCommentForm->handleRequest($request);
            if ($subCommentForm->isSubmitted() && $subCommentForm->isValid()) {
                $app['dao.comment']->save($comment);
                $app['session']->getFlashBag()->add('success', 'Your comment was successfully added.');
            }


            $subCommentFormView = $subCommentForm->createView();

        }


        return $app['twig']->render('commentReply_form.html.twig', array(
            'subCommentForm' => $subCommentFormView

        ));
    }


    public function signalCommentAction (Application $app)
    {
        $comment = $_GET['id'];
        $app['dao.comment']->signalComment($comment);


        return "commentaire"  . $_GET['id'] . " signalé !";

       
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
