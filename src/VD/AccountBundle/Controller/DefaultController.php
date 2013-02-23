<?php

namespace VD\AccountBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('VDAccountBundle:Default:index.html.twig', array('name' => $name));
    }
}
