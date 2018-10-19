<?php

namespace CommentVideoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
//        return $this->render('CommentVideoBundle:Default:index.html.twig');
        return $this->render('@CommentVideo/Default/index.html.twig');
    }
}
