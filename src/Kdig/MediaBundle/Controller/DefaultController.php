<?php

namespace Kdig\MediaBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

/**
 * Bucket controller.
 *
 * @Route("/media")
 */
class DefaultController extends Controller
{
    /**
     * @Route("/", name="media")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }
}
