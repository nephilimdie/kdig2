<?php

namespace Kdig\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

use Kdig\UserBundle\Entity\User as User;

/**
 * Bucket controller.
 *
 * @Route("/user")
 */
class DefaultController extends Controller
{
    /**
     * @Route("/", name="user_index")
     * @Template()
     */
    public function indexAction()
    {
        return false;
    }
    /**
     * @Route("/{group_id}", name="user_change_group")
     * @Method("POST")
     */
    public function changeGroupAction(Request $request)
    {
        return false;
    }
}
