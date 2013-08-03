<?php

namespace Kdig\OrientBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\View\TwitterBootstrapView;

use Kdig\OrientBundle\Entity\Bucket;
use Kdig\OrientBundle\Form\BucketType;
use Kdig\OrientBundle\Form\BucketFilterType;

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
 * @Route("/bucket")
 * @Breadcrumb("Bucket", route="bucket")
 */
class BucketController extends Controller
{
    /**
     * Lists all Object entities.ì in grid
     *
     * @Route("/", name="bucket")
     * @Breadcrumb("Table", route="bucket")
     * @Method("GET")
     * @Template("KdigTemplateBundle:Default:Grid/grid.html.twig")
     */
    public function myGridAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();
        
        $source = new Entity('KdigOrientBundle:Bucket');
        $grid = $this->get('grid');
        $grid->setSource($source);

        $grid->setDefaultOrder('name', 'asc');

        $actionsColumn = new ActionsColumn('info_column_1', 'Actions');
        $actionsColumn->setSeparator("<br />");
        $grid->addColumn($actionsColumn, 1);
        $showAction = new RowAction('Show', 'bucket_show');
        $showAction->setColumn('info_column');
        $grid->addRowAction($showAction);
        $grid->addMassAction(new DeleteMassAction());
        
        $fileName = 'bucket-'.date("d-m-Y");
        $export = new PHPExcel2007Export('Excel 2007',$fileName, array(), 'UTF-8', 'ROLE_ARCHAEOLOGY');

        $export->objPHPExcel->getProperties()->setCreator("KdigProject ".$user);
        $export->objPHPExcel->getProperties()->setLastModifiedBy("KdigProject");
        $export->objPHPExcel->getProperties()->setTitle("KdigProject ".$fileName);
        $export->objPHPExcel->getProperties()->setSubject("KdigProject Document");
        $export->objPHPExcel->getProperties()->setDescription("KdigProject");
        $export->objPHPExcel->getProperties()->setKeywords("KdigProject");
        $export->objPHPExcel->getProperties()->setCategory("KdigProject");
        
        $grid->addExport($export);
        
        $this->get('session')->getFlashBag()->add('success', 'yeahhhhh');
        // Manage the grid redirection, exports and the response of the controller
        return $grid->getGridResponse();
    }
    
    /**
     * Lists all Bucket entities.
     *
     * @Route("/home/", name="bucket_home")
     * @Breadcrumb("Home", route="bucket_home")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }

    /**
    * Create filter form and process filter request.
    *
    */
    protected function filter()
    {
        $request = $this->getRequest();
        $session = $request->getSession();
        $filterForm = $this->createForm(new BucketFilterType());
        $em = $this->getDoctrine()->getManager();
        $queryBuilder = $em->getRepository('KdigOrientBundle:Bucket')->createQueryBuilder('e');

        // Reset filter
        if ($request->get('filter_action') == 'reset') {
            $session->remove('BucketControllerFilter');
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
                $session->set('BucketControllerFilter', $filterData);
            }
        } else {
            // Get filter from session
            if ($session->has('BucketControllerFilter')) {
                $filterData = $session->get('BucketControllerFilter');
                $filterForm = $this->createForm(new BucketFilterType(), $filterData);
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
            return $me->generateUrl('bucket', array('page' => $page));
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
     * Creates a new Bucket entity.
     *
     * @Route("/", name="bucket_create")
     * @Method("POST")
     * @Template("KdigOrientBundle:Bucket:new.html.twig")
     * @Secure(roles="ROLE_ARCHAEOLOGY , ROLE_ADMIN")
     */
    public function createAction(Request $request)
    {
        $entity  = new Bucket();
        
        $areas = $this->getArea();
        $usid = null;
        if($request->get('usid'))
            $usid = $request->get('usid');
        
        $form = $this->createForm(new BucketType($areas, $usid), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.create.success');

            return $this->redirect($this->generateUrl('bucket_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Bucket entity.
     *
     * @Route("/new", name="bucket_new")
     * @Breadcrumb("New bucket", route="bucket_new")
     * @Template()
     * @Secure(roles="ROLE_ARCHAEOLOGY , ROLE_ADMIN")
     */
    public function newAction(Request $request)
    {
        $areas = $this->getArea();
        $usid = null;
        if($request->get('usid'))
            $usid = $request->get('usid');
        
        $entity = new Bucket();
        $form   = $this->createForm(new BucketType($areas, $usid), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Bucket entity.
     *
     * @Route("/{id}", name="bucket_show")
     * @Breadcrumb("Show bucket",  route={"name"=""bucket_show", "parameters"={"id"}})
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KdigOrientBundle:Bucket')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Bucket entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Bucket entity.
     *
     * @Route("/{id}/edit", name="bucket_edit")
     * @Method("GET")
     * @Template()
     * @Secure(roles="ROLE_ARCHAEOLOGY , ROLE_ADMIN")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KdigOrientBundle:Bucket')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Bucket entity.');
        }

        $request = $this->getRequest();
        $areas = $this->getArea();
        $usid = null;
        if($request->get('usid'))
            $usid = $request->get('usid');
        
        $editForm = $this->createForm(new BucketType($areas, $usid), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Bucket entity.
     *
     * @Route("/{id}", name="bucket_update")
     * @Method("PUT")
     * @Template("KdigOrientBundle:Bucket:edit.html.twig")
     * @Secure(roles="ROLE_ARCHAEOLOGY , ROLE_ADMIN")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KdigOrientBundle:Bucket')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Bucket entity.');
        }

        $areas = $this->getArea();
        $usid = null;
        if($request->get('usid'))
            $usid = $request->get('usid');
        
        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new BucketType($areas, $usid), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.update.success');

            return $this->redirect($this->generateUrl('bucket_edit', array('id' => $id)));
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
     * Deletes a Bucket entity.
     *
     * @Route("/{id}", name="bucket_delete")
     * @Method("DELETE")
     * @Secure(roles="ROLE_ARCHAEOLOGY , ROLE_ADMIN")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('KdigOrientBundle:Bucket')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Bucket entity.');
            }

            $em->remove($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.delete.success');
        } else {
            $this->get('session')->getFlashBag()->add('error', 'flash.delete.error');
        }

        return $this->redirect($this->generateUrl('bucket'));
    }

    /**
     * Creates a form to delete a Bucket entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
    
    /**
     * Get a default text for Us from selected us.
     *
     * @Route("/{id_us}/getdefaulttext", name="kdig_bucket_defaulttext", options={"expose"=true})
     * @Method("post")
     */
    public function getdefaulttextaction(Request $request) 
    {
        $user = $this->get('security.context')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $id_us = $request->get('id_us');
        $us = $em->getRepository('KdigArchaeologicalBundle:Us')->findOneById($id_us);
        if (!$us) {
            throw $this->createNotFoundException('Unable to find Us entity.');
        }
        $sigla = $us->getSite();
        $stringa = $em->getRepository('KdigOrientBundle:Bucket')->freeName($sigla, $user);
        
        return new Response($stringa);
    }
    
    private function getArea() {
        
        $user = $this->get('security.context')->getToken()->getUser();
        $group = $user->getSlectedgroup();
        foreach ($group->getAreas() as $area)
            $areas[]=$area->getId(); 
        return $areas;
    }
}
