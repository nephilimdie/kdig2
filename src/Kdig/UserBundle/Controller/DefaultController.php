<?php

namespace Kdig\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('KdigUserBundle:Default:index.html.twig', array('name' => $name));
    }
}
