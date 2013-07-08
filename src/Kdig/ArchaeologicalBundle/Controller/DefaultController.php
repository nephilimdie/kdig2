<?php

namespace Kdig\ArchaeologicalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('KdigArchaeologicalBundle:Default:index.html.twig', array('name' => $name));
    }
}
