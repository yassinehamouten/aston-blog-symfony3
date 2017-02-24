<?php

namespace yh\commentsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('yhcommentsBundle:Default:index.html.twig');
    }
}
