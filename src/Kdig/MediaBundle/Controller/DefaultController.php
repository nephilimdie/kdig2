<?php

namespace Kdig\MediaBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

use APY\DataGridBundle\Grid\Source\Entity;
use APY\DataGridBundle\Grid\Action\RowAction;
use APY\DataGridBundle\Grid\Action\MassAction;
use APY\DataGridBundle\Grid\Action\DeleteMassAction;
use APY\DataGridBundle\Grid\Column\ActionsColumn;
use APY\DataGridBundle\Grid\Export\PHPExcel2007Export;

use APY\BreadcrumbTrailBundle\Annotation\Breadcrumb;

use JMS\SecurityExtraBundle\Annotation\Secure;
/**
 * Bucket controller.
 *
 * @Route("/media")
 */
class DefaultController extends Controller
{
    /**
     * @Route("/", name="media_index")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }
    
    /**
     * @Route("/home/", name="media_home")
     * @Secure(roles="ROLE_MEDIA , ROLE_ADMIN")
     * @Template()
     */
    public function homeAction()
    {
        return array();
    }
    
    /**
     * @Route("/home/", name="media_new")
     * @Secure(roles="ROLE_MEDIA , ROLE_ADMIN")
     * @Template()
     */
    public function uploadAction()
    { 
        
    }
    /**
     * @Route("/getmediafromquery", name="media_getmediafromquery")
     */
    public function getmediafromquery(Request $request)
    {
        $value = $request->get('q');
        $callback = $request->get('callback');
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('KedigMediaBundle:Media')->findAllUseLike($value);//findBy(array('name'=>$value));
        $json = array();
        foreach ($entities as $member) {
            $json[] = array(
                'id'    =>  $member->getId(),
                'name'  =>  $member->getName(),
                'size'  =>  $member->getSize(),
                'mime'  =>  $member->getMime()
            );
        }

        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $result = array('results'=>$json);
        $result["total"] = 959;
        $response->setContent(json_encode($result));

        return $response;
    }
    /**
     * Finds and displays a Media entity with json.
     *
     * @Route("/showjson", name="media_showjson")
     */
    public function showjsonAction(Request $request)
    {
        $id = (int)$request->get('id');
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KedigMediaBundle:Media')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Media entity.');
        }

        $json = array();
        $json[] = array(
            'id'    =>  $entity->getId(),
            'name'  =>  $entity->getName(),
            'size'  =>  $entity->getSize(),
            'mime'  =>  $entity->getMime()
        );
        $response = new Response();
        //die(var_dump($json));
        $response->headers->set('Content-Type', 'application/json');
        $result = array('result'=>$json);
        $response->setContent(json_encode($json));
        
        return $response;
    }
}
