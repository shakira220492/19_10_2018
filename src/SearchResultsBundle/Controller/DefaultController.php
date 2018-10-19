<?php

namespace SearchResultsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@SearchResults/Default/index.html.twig');
    }
}
