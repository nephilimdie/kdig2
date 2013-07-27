<?php

namespace Kdig\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

use Kdig\UserBundle\Entity\User as User;
use JMS\SecurityExtraBundle\Annotation\Secure;

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
     * @Route("/group/", name="user_change_group")
     * @Secure(roles="IS_AUTHENTICATED_FULLY")
     */
    public function changeGroupAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $user = $this->get('security.context')->getToken()->getUser();
        $group = $em->getRepository('KdigUserBundle:Group')->find($request->get('group_id'));
        
        if (!$group) {
            throw $this->createNotFoundException('Unable to find group entity.');
        }
        $entity->setSlectedgroup($group);
        $em->persist($entity);
        $em->flush();
        return false;
    }
}
