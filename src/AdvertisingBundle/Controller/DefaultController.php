<?php

namespace AdvertisingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@Advertising/Default/index.html.twig');
    }
}
