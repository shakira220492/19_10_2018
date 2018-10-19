<?php

namespace HomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class d_PremiumController extends Controller
{
    public function indexAction()
    {
        return $this->render('@Home/d_Premium/index.html.twig');
    }
    
//    there will be next options:
//    offers the user the oportunity to adquire the option premium which own the alternative to 
//    use this app: 
//    WITHOUT ANNOUNCES, PUBLICITY, AND ADVERTISING
//    login - logout
    
}
