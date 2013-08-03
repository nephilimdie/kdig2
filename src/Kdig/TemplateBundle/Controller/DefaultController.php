<?php

namespace Kdig\TemplateBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Template controller.
 *
 * @Route("/template")
 */
class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('KdigTemplateBundle:Default:index.html.twig', array('name' => $name));
    }
    
    /**
     * @Route("/", name="tamplate_flash")
     * @Method("GET")
     * @Template("KdigTemplateBundle:Default:renderFlash.html.twig")
     */
    public function renderFlashAction() {
        return array();
    }
}
