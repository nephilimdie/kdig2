<?php

namespace Kdig\ArchaeologicalBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\View\TwitterBootstrapView;

use Kdig\ArchaeologicalBundle\Entity\Preobject;
use Kdig\ArchaeologicalBundle\Form\PreobjectType;
use Kdig\ArchaeologicalBundle\Form\PreobjectFilterType;

use APY\DataGridBundle\Grid\Source\Entity;
use APY\DataGridBundle\Grid\Action\RowAction;
use APY\DataGridBundle\Grid\Action\MassAction;
use APY\DataGridBundle\Grid\Action\DeleteMassAction;
use APY\DataGridBundle\Grid\Column\ActionsColumn;
use APY\DataGridBundle\Grid\Export\PHPExcel2007Export;

use APY\BreadcrumbTrailBundle\Annotation\Breadcrumb;

use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * Preobject controller.
 *
 * @Route("/preobject")
 * @Breadcrumb("Object", route="preobject")
 */
class PreobjectController extends Controller
{
    /**
     * Lists all Preobject entities.ì in grid
     *
     * @Route("/", name="preobject")
     * @Breadcrumb("Table", route="preobject")
     * @Template("KdigTemplateBundle:Default:Grid/grid.html.twig")
     */
    public function myGridAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();
        
        $source = new Entity('KdigArchaeologicalBundle:Preobject');
        $grid = $this->get('grid');
        $grid->setSource($source);

        $grid->setDefaultOrder('name', 'asc');

        $actionsColumn = new ActionsColumn('info_column_1', 'Actions');
        $actionsColumn->setSeparator("<br />");
        $grid->addColumn($actionsColumn, 1);
        $showAction = new RowAction('Show', 'preobject_show');
        $showAction->setColumn('info_column');
        $grid->addRowAction($showAction);
        $grid->addMassAction(new DeleteMassAction());
        
        $fileName = 'object-'.date("d-m-Y");
        $export = new PHPExcel2007Export('Excel 2007',$fileName, array(), 'UTF-8', 'ROLE_ARCHAEOLOGY');

        $export->objPHPExcel->getProperties()->setCreator("KdigProject ".$user);
        $export->objPHPExcel->getProperties()->setLastModifiedBy("KdigProject");
        $export->objPHPExcel->getProperties()->setTitle("KdigProject ".$fileName);
        $export->objPHPExcel->getProperties()->setSubject("KdigProject Document");
        $export->objPHPExcel->getProperties()->setDescription("KdigProject");
        $export->objPHPExcel->getProperties()->setKeywords("KdigProject");
        $export->objPHPExcel->getProperties()->setCategory("KdigProject");
        
        $grid->addExport($export);
        // Manage the grid redirection, exports and the response of the controller
        return $grid->getGridResponse();
    }
    /**
     * Lists all Preobject entities.
     *
     * @Route("/home/", name="preobject_home")
     * @Breadcrumb("Object Home", route="preobject_home")
     * @Template()
     * @Secure(roles="ROLE_ARCHAEOLOGY, ROLE_ADMIN, ROLE_POTTERY, ROLE_SAMPLE, ROLE_OBJECT")
     */
    public function indexAction()
    {
        list($filterForm, $queryBuilder) = $this->filter();

        list($entities, $pagerHtml) = $this->paginator($queryBuilder);

        return array(
            'entities' => $entities,
            'pagerHtml' => $pagerHtml,
            'filterForm' => $filterForm->createView(),
        );
    }

    /**
    * Create filter form and process filter request.
    *
    */
    protected function filter()
    {
        $request = $this->getRequest();
        $session = $request->getSession();
        $filterForm = $this->createForm(new PreobjectFilterType());
        $em = $this->getDoctrine()->getManager();
        $queryBuilder = $em->getRepository('KdigArchaeologicalBundle:Preobject')->createQueryBuilder('e');

        // Reset filter
        if ($request->get('filter_action') == 'reset') {
            $session->remove('PreobjectControllerFilter');
        }

        // Filter action
        if ($request->get('filter_action') == 'filter') {
            // Bind values from the request
            $filterForm->bind($request);

            if ($filterForm->isValid()) {
                // Build the query from the given form object
                $this->get('lexik_form_filter.query_builder_updater')->addFilterConditions($filterForm, $queryBuilder);
                // Save filter to session
                $filterData = $filterForm->getData();
                $session->set('PreobjectControllerFilter', $filterData);
            }
        } else {
            // Get filter from session
            if ($session->has('PreobjectControllerFilter')) {
                $filterData = $session->get('PreobjectControllerFilter');
                $filterForm = $this->createForm(new PreobjectFilterType(), $filterData);
                $this->get('lexik_form_filter.query_builder_updater')->addFilterConditions($filterForm, $queryBuilder);
            }
        }

        return array($filterForm, $queryBuilder);
    }

    /**
    * Get results from paginator and get paginator view.
    *
    */
    protected function paginator($queryBuilder)
    {
        // Paginator
        $adapter = new DoctrineORMAdapter($queryBuilder);
        $pagerfanta = new Pagerfanta($adapter);
        $currentPage = $this->getRequest()->get('page', 1);
        $pagerfanta->setCurrentPage($currentPage);
        $entities = $pagerfanta->getCurrentPageResults();

        // Paginator - route generator
        $me = $this;
        $routeGenerator = function($page) use ($me)
        {
            return $me->generateUrl('preobject', array('page' => $page));
        };

        // Paginator - view
        $translator = $this->get('translator');
        $view = new TwitterBootstrapView();
        $pagerHtml = $view->render($pagerfanta, $routeGenerator, array(
            'proximity' => 3,
            'prev_message' => $translator->trans('views.index.pagprev', array(), 'JordiLlonchCrudGeneratorBundle'),
            'next_message' => $translator->trans('views.index.pagnext', array(), 'JordiLlonchCrudGeneratorBundle'),
        ));

        return array($entities, $pagerHtml);
    }

    /**
     * Creates a new Preobject entity.
     *
     * @Route("/", name="preobject_create")
     * @Method("POST")
     * @Template("KdigArchaeologicalBundle:Preobject:new.html.twig")
     * @Secure(roles="ROLE_ARCHAEOLOGY , ROLE_ADMIN")
     */
    public function createAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.context')->getToken()->getUser();
        $bucketid = null;
        if($request->get('bucket_id'))
            $bucketid = $request->get('bucket_id');
        $usid = null;
        if($request->get('us_id'))
            $usid = $request->get('us_id');
        
        if ($bucketid==null || $bucketid=='')
            $bucketid = $em->getRepository('KdigOrientBundle:Bucket')->getmygroupelement($user);
        
        $entity  = new Preobject();
        $form = $this->createForm(new PreobjectType($bucketid,$usid), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.create.success');

            return $this->redirect($this->generateUrl('preobject_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Preobject entity.
     *
     * @Route("/new/", name="preobject_new")
     * @Breadcrumb("New object", route="preobject_new")
     * @Template()
     * @Secure(roles="ROLE_ARCHAEOLOGY , ROLE_ADMIN")
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.context')->getToken()->getUser();
        $bucketid = null;
        if($request->get('bucket_id'))
            $bucketid = $request->get('bucket_id');
        $usid = null;
        if($request->get('us_id'))
            $usid = $request->get('us_id');
        
        if ($bucketid==null || $bucketid=='')
            $bucketid = $em->getRepository('KdigOrientBundle:Bucket')->getmygroupelement($user);
        
        $entity = new Preobject();
        $form   = $this->createForm(new PreobjectType($bucketid,$usid), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Preobject entity.
     *
     * @Route("/{id}/show", name="preobject_show")
     * @Breadcrumb("Show object",  route={"name"="preobject_show", "parameters"={"id"}})
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KdigArchaeologicalBundle:Preobject')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Preobject entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Preobject entity.
     *
     * @Route("/{id}/edit", name="preobject_edit")
     * @Breadcrumb("Edit object",  route={"name"="preobject_edit", "parameters"={"id"}})
     * @Method("GET")
     * @Template()
     * @Secure(roles="ROLE_ARCHAEOLOGY , ROLE_ADMIN")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.context')->getToken()->getUser();
        $bucketid = null;
        if($request->get('bucket_id'))
            $bucketid = $request->get('bucket_id');
        
        if ($bucketid==null || $bucketid=='')
            $bucketid = $em->getRepository('KdigOrientBundle:Bucket')->getmygroupelement($user);
        
        $entity = $em->getRepository('KdigArchaeologicalBundle:Preobject')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Preobject entity.');
        }

        $editForm = $this->createForm(new PreobjectType($bucketid,null), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Preobject entity.
     *
     * @Route("/{id}", name="preobject_update")
     * @Method("PUT")
     * @Template("KdigArchaeologicalBundle:Preobject:edit.html.twig")
     * @Secure(roles="ROLE_ARCHAEOLOGY , ROLE_ADMIN")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.context')->getToken()->getUser();
        $bucketid = null;
        if($request->get('bucket_id'))
            $bucketid = $request->get('bucket_id');
        
        if ($bucketid==null || $bucketid=='')
            $bucketid = $em->getRepository('KdigOrientBundle:Bucket')->getmygroupelement($user);
        
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KdigArchaeologicalBundle:Preobject')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Preobject entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new PreobjectType($bucketid,null), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.update.success');

            return $this->redirect($this->generateUrl('preobject_edit', array('id' => $id)));
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
     * Deletes a Preobject entity.
     *
     * @Route("/{id}/delete", name="preobject_delete")
     *
     * @Secure(roles="ROLE_ARCHAEOLOGY , ROLE_ADMIN")
     */
    public function deleteAction(Request $request, $id)
    {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('KdigArchaeologicalBundle:Preobject')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Preobject entity.');
            }

            $em->remove($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.delete.success');

        return $this->redirect($this->generateUrl('preobject'));
    }
    
    /**
     * Get a default text for Bucket from selected us.
     *
     * @Route("/getdefaulttext", name="kdig_preobject_defaulttext", options={"expose"=true})
     * @Method("post")
     */
    public function getdefaulttextAction(Request $request) 
    {
        $id_bucket = $request->get('id_bucket');
        $em = $this->getDoctrine()->getManager();
        $bucket = $em->getRepository('KdigOrientBundle:Bucket')->findOneById($id_bucket);
        if (!$bucket) {
            throw $this->createNotFoundException('Unable to find Bucket entity.');
        }
        $stringa = $em->getRepository('KdigArchaeologicalBundle:Preobject')->freeName($bucket);
        
        return new Response($stringa);
    }
}
