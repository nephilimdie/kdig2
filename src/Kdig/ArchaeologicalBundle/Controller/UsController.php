<?php

namespace Kdig\ArchaeologicalBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\View\TwitterBootstrapView;

use Kdig\ArchaeologicalBundle\Entity\Us;
use Kdig\ArchaeologicalBundle\Form\UsType;
use Kdig\ArchaeologicalBundle\Form\UsFilterType;

use APY\DataGridBundle\Grid\Source\Entity;
use APY\DataGridBundle\Grid\Action\RowAction;
use APY\DataGridBundle\Grid\Column\ActionsColumn;
use APY\DataGridBundle\Grid\Export\PHPExcel2007Export;
use APY\DataGridBundle\Grid\Export\CSVExport;
use APY\BreadcrumbTrailBundle\Annotation\Breadcrumb;

/* start - for json api */
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use JMS\DiExtraBundle\Annotation\Inject;
use JMS\SecurityExtraBundle\Annotation\Secure;

use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Routing\ClassResourceInterface;
/* end - for json api */

/**
 * Us controller.
 *
 * @Route("/us")
 * @Breadcrumb("Stratigraphics Unit", route="us")
 */
class UsController extends Controller
{
    
/************************/
/* start new environment*/
/************************/
    
    /**
     * @Inject("doctrine")
     */
    protected $doctrine;

    /**
     * @Inject("form.factory")
     */
    protected $formFactory;

    /**
     * @Inject("request")
     */
    protected $request;

    /**
     * @Inject("jms_serializer")
     */
    protected $serializer;

    /**
     * Gets the Us repository
     *
     * @return Doctrine\Common\Persistence\AbstractManagerRegistry
     */
    private function getUsRepository()
    {
        return $this
            ->doctrine
            ->getRepository('KdigArchaeologicalBundle:Us');
    }
    
    /**
     * Reads (all the collection)
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @Rest\View(serializerGroups={"usList"})
     */
    public function cgetAction()
    {
        return $this
                ->getUsRepository()
                ->findAll()
        ;
    }

    /**
     * Reads (an element)
     *
     * @param  int  $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * 
     * @Rest\View(serializerGroups={"usDetail"})
     * @ParamConverter("id", class="KdigArchaeologicalBundle:Us")
     */
    public function getAction(Us $id)
    {
        return $id;
    }

    /**
     * Creates
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @ PreAuthorize("isFullyAuthenticated()")
     */
    public function cpostAction()
    {
        return $this->processForm(new Us());
    }

    /**
     * Updates
     *
     * @param  int   $us
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @ PreAuthorize("isFullyAuthenticated()")
     */
    public function putAction($id)
    {
        $us = $this
            ->getUsRepository()
            ->find($id)
        ;

        if (!$us instanceof Us) {
            throw new NotFoundHttpException();
        }

        return $this->processForm($us);
    }
    
    /**
     * Deletes
     *
     * @param  int  $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @ PreAuthorize("isFullyAuthenticated()")
     */
    public function delete2Action($id)
    {
        $us = $this
            ->getUsRepository()
            ->find($id)
        ;

        if (!$us instanceof Us) {
            throw new NotFoundHttpException();
        }

        $this->doctrine->getEntityManager()->remove($us);
        $this->doctrine->getEntityManager()->flush();

        return new Response();
    }

    /**
     * @param Us $us
     * @return \Symfony\Component\HttpFoundation\Response|\FOS\RestBundle\View\View
     */
    protected function processForm(Us $us)
    {
        $statusCode = $us->getId() > 0 ? 204 : 201;
        $form = $this->formFactory->create(new UsType(), $us);
        $form->bind($this->request);

        if ($form->isValid()) {
            $em = $this->doctrine->getEntityManager();
            $em->persist($us);
            $em->flush();

            $response = new Response();
            $response->setContent($this->serializer->serialize($us, 'json'));
            $response->setStatusCode($statusCode);

            return $response;
        }

        return View::create($form, 400);
    }
    
    
/**********************/    
/* end new environment*/
/**********************/
 
    
    
    
    /**
     * Lists all Us entities in grid
     *
     * @Route("/", name="us")
     * @Breadcrumb("Table", route="us")
     * @Secure(roles="ROLE_ARCHAEOLOGY, ROLE_ADMIN, ROLE_POTTERY, ROLE_SAMPLE, ROLE_OBJECT")
     */
    public function myGridAction() {
        $source = new Entity('KdigArchaeologicalBundle:Us');
        $grid = $this->get('grid');
        $grid->setSource($source);
        // Configuration of the grid
        // 
        // Create an Actions Column
        $actionsColumn = new ActionsColumn('info_column_1', 'Actions');
        $actionsColumn->setSeparator("<br />");
        $grid->addColumn($actionsColumn, 1);

        // Attach a rowAction to the Actions Column
        $showAction = new RowAction('Show', 'us_show', null, null, array('class'=>'ajax'));
        $showAction->setColumn('info_column');
        $grid->addRowAction($showAction);
//        // OR add a second row action directly to a new action column
//        $rowAction2 = new RowAction('Edit', 'pottery_edit');
//        $actionsColumn2 = new ActionsColumn($column, $title, array(rowAction2), $separator);
//        $grid->addColumn($actionsColumn2, $position2);
        $fileName = 'su-excel-'.date("d-m-Y");
        $export = new PHPExcel2007Export('Excel2007 SU Export', $fileName);

        $export->objPHPExcel->getProperties()->setCreator("KdigProject");
        $export->objPHPExcel->getProperties()->setLastModifiedBy("KdigProject");
        $export->objPHPExcel->getProperties()->setTitle("KdigProject Document");
        $export->objPHPExcel->getProperties()->setSubject("KdigProject Stratigraphics Units");
        $export->objPHPExcel->getProperties()->setDescription("KdigProject");
        $export->objPHPExcel->getProperties()->setKeywords("KdigProject");
        $export->objPHPExcel->getProperties()->setCategory("KdigProject");
        
        $fileName = 'su-csv-'.date("d-m-Y");
        $csvExport = new CSVExport('CSV Export', $fileName);
        
        $grid->addExport($export);
        $grid->addExport($csvExport);
        
        // Manage the grid redirection, exports and the response of the controller
        return $grid->getGridResponse('KdigTemplateBundle:Default:Grid\grid.html.twig');
    }
    
    /**
     * Lists all Us entities.
     *
     * @Route("/home/", name="us_home")
     * @Breadcrumb("SU Home", route="us_home")
     * @Secure(roles="ROLE_ARCHAEOLOGY, ROLE_ADMIN, ROLE_POTTERY, ROLE_SAMPLE, ROLE_OBJECT")
     * @Template()
     */
    public function indexAction() {
        return array(
        );
    }

    private function getArea() {
        
        $user = $this->get('security.context')->getToken()->getUser();
        $group = $user->getSlectedgroup();
        foreach ($group->getAreas() as $area)
            $areas[]=$area->getId(); 
        return $areas;
    }
    
    /**
     * Creates a new Us entity.
     *
     * @Route("/us_create/", name="us_create")
     * @Method("POST")
     * @Template("KdigArchaeologicalBundle:Us:new.html.twig")
     * @Secure(roles="ROLE_ARCHAEOLOGY, ROLE_ADMIN, ROLE_POTTERY, ROLE_SAMPLE, ROLE_OBJECT")
     */
    public function createAction(Request $request) {
        $areas = $this->getArea();
        $entity  = new Us();
        $form = $this->createForm(new UsType($areas, null), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.create.success');

            return $this->redirect($this->generateUrl('us_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }
    
    /**
     * Displays a form to create a new Us entity.
     *
     * @Route("/new", name="us_new")
     * @Breadcrumb("New SU", route="us_new")
     * @Secure(roles="ROLE_ARCHAEOLOGY, ROLE_ADMIN, ROLE_POTTERY, ROLE_SAMPLE, ROLE_OBJECT")
     * @Template()
     */
    public function newAction() {
        $areas = $this->getArea();
        $entity = new Us();
        $form   = $this->createForm(new UsType($areas, null), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Us entity.
     *
     * @Route("/{id}/show", name="us_show")
     * @Breadcrumb("Show SU",  route={"name"="us_show", "parameters"={"id"}})
     * @Method("GET")
     * @Template()
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KdigArchaeologicalBundle:Us')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Us entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Us entity.
     *
     * @Route("/{id}/edit", name="us_edit")
     * @Breadcrumb("Edit SU",  route={"name"="us_edit", "parameters"={"id"}})
     * @Secure(roles="ROLE_ARCHAEOLOGY, ROLE_ADMIN, ROLE_POTTERY, ROLE_SAMPLE, ROLE_OBJECT")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KdigArchaeologicalBundle:Us')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Us entity.');
        }

        $areas = $this->getArea();
        
        $editForm = $this->createForm(new UsType($areas, null), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Us entity.
     *
     * @Route("/{id}/update", name="us_update")
     * @Method("PUT")
     * @Template("KdigArchaeologicalBundle:Us:edit.html.twig")
     * @Secure(roles="ROLE_ARCHAEOLOGY, ROLE_ADMIN, ROLE_POTTERY, ROLE_SAMPLE, ROLE_OBJECT")
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KdigArchaeologicalBundle:Us')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Us entity.');
        }
        $areas = $this->getArea();

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new UsType($areas, null), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.update.success');

            return $this->redirect($this->generateUrl('us_show', array('id' => $id)));
        } else {
            $this->get('session')->getFlashBag()->add('error', 'flash.update.error');
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Us entity.
     *
     * @Route("/{id}/delete", name="us_delete")
     *
     * @Secure(roles="ROLE_ARCHAEOLOGY, ROLE_ADMIN, ROLE_POTTERY, ROLE_SAMPLE, ROLE_OBJECT")
     */
    public function deleteAction(Request $request, $id) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('KdigArchaeologicalBundle:Us')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Us entity.');
            }

            $em->remove($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.delete.success');
        return $this->redirect($this->generateUrl('us'));
    }

    /**
     * Creates a form to delete a Us entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
    
    /**
     * Get a default text for Us from selected us.
     *
     * @Route("/{id_site}/{id_area}/getdefaulttext", name="kdig_us_defaulttext", options={"expose"=true})
     * @Method("post")
     */
    public function getdefaulttextaction(Request $request) {
        $user = $this->get('security.context')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $id_site = $request->get('id_site');
        $id_area = $request->get('id_area');
        $site = $em->getRepository('KdigArchaeologicalBundle:Site')->findOneById($id_site);
        $sigla = $site->getSigla();

        $area = $em->getRepository('KdigArchaeologicalBundle:Area')->findOneById($id_area);
        if (!$area) {
            throw $this->createNotFoundException('Unable to find Area entity.');
        }
        $stringa = $em->getRepository('KdigArchaeologicalBundle:Us')->freeName($sigla, $area);
        
        return new Response($stringa);
    }
    
    /** 
     * Get a default text for Us from selected us.
     *
     * @Route("/{name}/checkname", name="kdig_us_checkname", options={"expose"=true})
     * @Method("get")
     */
    public function checkname($name) { 
        $em = $this->getDoctrine()->getEntityManager();
        $response = $em->getRepository('KdigArchaeologicalBundle:Us')->isUnusedName($name);
        if($response)
            $stringa = '<label style="button green">OK</label>';
        else 
            $stringa = '<label style="button red">the name exist <a href="'.$this->generateUrl('kdig_us_show', array('id' => $response->getId())).'">'.$response->getName().'</a></label>';
        return new Response($stringa);
    }
}
