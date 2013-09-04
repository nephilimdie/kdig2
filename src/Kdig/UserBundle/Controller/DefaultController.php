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
        
        $i=0;
        foreach ($group->getAreas() as $area) {
            $i++;
            $automaticSelectedArea = $area;
        }
        if($i==1)
            $entity->setSlectedarea($automaticSelectedArea);
        
        $em->persist($entity);
        $em->flush();
        $this->get('session')->getFlashBag()->add('success', 'Group Selected '.$entity->getSlectedgroup());
        
        return $this->redirect($this->generateUrl('default_index'));
        //return new Response($group->getName().'<b class="caret"></b>');
    }
    /**
     * @Route("/area/", name="user_change_area")
     * @Secure(roles="IS_AUTHENTICATED_FULLY")
     */
    public function changeAreaAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $user = $this->get('security.context')->getToken()->getUser();
        $area = $em->getRepository('KdigArchaeologicalBundle:Area')->find($request->get('area_id'));
        
        if (!$area) {
            throw $this->createNotFoundException('Unable to find group entity.');
        }
        $entity->setSlectedarea($area);
        $em->persist($entity);
        $em->flush();
        $this->get('session')->getFlashBag()->add('success', 'Area Selected '.$entity->getSlectedarea());
        
        return $this->redirect($this->generateUrl('default_index'));
        //return new Response($group->getName().'<b class="caret"></b>');
    }
}
