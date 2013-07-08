<?php

namespace Kdig\OrientBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('KdigOrientBundle:Default:index.html.twig', array('name' => $name));
    }
}
