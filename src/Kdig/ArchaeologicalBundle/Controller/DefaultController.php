<?php

namespace Kdig\ArchaeologicalBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Ob\HighchartsBundle\Highcharts\Highchart;

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
     * @Route("/", name="default_index", options={"sitemap" = true})
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }
    
    /**
     * @Route("/about", name="default_about", options={"sitemap" = true})
     * @Template()
     */
    public function aboutAction()
    {
        return array();
    }
}
