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
 * @Route("/bucket")
 */
class UserController extends Controller
{
    /**
     * @Route("/{group_id}}", name="user_change_group")
     * @Method("POST")
     */
    public function changeGroupAction(Request $request)
    {
        
    }
}
