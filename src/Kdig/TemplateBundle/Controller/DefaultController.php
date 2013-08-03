<?php

namespace Kdig\TemplateBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

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
     * @Route("/flash", name="tamplate_flash")
     * @Method("GET")
     * @Template("KdigTemplateBundle:Default:renderFlash.html.twig")
     */
    public function renderFlashAction() {
        return array();
    }
}
