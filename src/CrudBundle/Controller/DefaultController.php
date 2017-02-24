<?php

namespace CrudBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $test = "bonjour";
        $data["test"] = $test;
        return $this->render('CrudBundle:Default:index.html.twig', $data);
    }
    
    public function bonjourAction($id)
    {
        $test = "bonjour";
        $data["test"] = $test." ".$id;
        return $this->render('CrudBundle:Default:index.html.twig', $data);
    }
}
