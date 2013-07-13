<?php

namespace Kdig\ArchaeologicalBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;


/**
 * Index controller.
 *
 * @Route("/")
 */
class DefaultController extends Controller
{
    /**
     * Lists all Index entities.
     *
     * @Route("/", name="default_index")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }
}
