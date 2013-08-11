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

use Kdig\ArchaeologicalBundle\Entity\Prepottery;
use Kdig\ArchaeologicalBundle\Form\PrepotteryType;
use Kdig\ArchaeologicalBundle\Form\PrepotteryFilterType;

use APY\DataGridBundle\Grid\Source\Entity;
use APY\DataGridBundle\Grid\Action\RowAction;
use APY\DataGridBundle\Grid\Action\MassAction;
use APY\DataGridBundle\Grid\Action\DeleteMassAction;
use APY\DataGridBundle\Grid\Column\ActionsColumn;
use APY\DataGridBundle\Grid\Export\PHPExcel2007Export;

use APY\BreadcrumbTrailBundle\Annotation\Breadcrumb;

use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * Prepottery controller.
 *
 * @Route("/prepottery")
 * @Breadcrumb("Pottery", route="prepottery_home")
 */
class PrepotteryController extends Controller
{
    
    /**
     * Lists all object entities.
     *
     * @Route("/", name="prepottery")
     * @Breadcrumb("Table", route="prepottery")
     * @Template("KdigTemplateBundle:Default:Grid/grid.html.twig")
     * @Secure(roles="ROLE_ARCHAEOLOGY, ROLE_ADMIN, ROLE_POTTERY, ROLE_SAMPLE, ROLE_OBJECT")
     */
    public function myGridAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();
        $group = $user->getSlectedgroup();
        
        $em = $this->getDoctrine()->getEntityManager();
        
        $bucketid = $em->getRepository('KdigOrientBundle:Bucket')->getmygroupelement($user);
        $ids = $em->getRepository('KdigArchaeologicalBundle:Prepottery')->getmygroupelement($bucketid);

        $source = new Entity('KdigArchaeologicalBundle:Prepottery');
        $tableAlias = $source::TABLE_ALIAS;
        $source->manipulateQuery(function ($query) use ($tableAlias, $ids)
        {
            $query->andWhere($query->expr()->in($tableAlias .'.id', $ids));
        });
        
        $grid = $this->get('grid');
        
        $grid->setActionsColumnSize(100);
        $grid->setSource($source);
        
        $grid->setId('datagrid_prepottery');
        $grid->setLimits(array(20, 50, 100, 1000));

        $rowAction1 = new RowAction('Show', 'prepottery_show', false, '_self', array('class' => 'icon icon199 grid_show_action'));
        $grid->addRowAction($rowAction1);
        
        if ( $group->hasRole('ROLE_ARCHEOLOGO')) {
            $grid->addMassAction(new DeleteMassAction());
            $rowAction2 = new RowAction('Edit', 'prepottery_edit', false, '_self', array('class' => 'icon icon145 grid_edit_action'));
            $grid->addRowAction($rowAction2);
            $rowAction = new RowAction('Delete', 'prepottery_delete', true, '_self', array('class' => 'icon icon58 grid_delete_action'));
            $grid->addRowAction($rowAction);
        }
        $fileName = 'Pottery-'.date("d-m-Y");
        $export = new PHPExcel2007Export('Excel 2007',$fileName, array(), 'UTF-8', 'ROLE_POTTERY');

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
     * Lists all Prepottery entities.
     *
     * @Route("/home/", name="prepottery_home")
     * @Breadcrumb("Pottery Home", route="prepottery")
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
        $filterForm = $this->createForm(new PrepotteryFilterType());
        $em = $this->getDoctrine()->getManager();
        $queryBuilder = $em->getRepository('KdigArchaeologicalBundle:Prepottery')->createQueryBuilder('e');

        // Reset filter
        if ($request->get('filter_action') == 'reset') {
            $session->remove('PrepotteryControllerFilter');
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
                $session->set('PrepotteryControllerFilter', $filterData);
            }
        } else {
            // Get filter from session
            if ($session->has('PrepotteryControllerFilter')) {
                $filterData = $session->get('PrepotteryControllerFilter');
                $filterForm = $this->createForm(new PrepotteryFilterType(), $filterData);
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
            return $me->generateUrl('prepottery', array('page' => $page));
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
     * Creates a new Prepottery entity.
     *
     * @Route("/", name="prepottery_create")
     * @Method("POST")
     * @Template("KdigArchaeologicalBundle:Prepottery:new.html.twig")
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
        
        $entity  = new Prepottery();
        $form = $this->createForm(new PrepotteryType($bucketid,$usid), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.create.success');

            return $this->redirect($this->generateUrl('prepottery_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Prepottery entity.
     *
     * @Route("/new", name="prepottery_new")
     * @Breadcrumb("New pottery", route="prepottery_new")
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
        
        $entity = new Prepottery();
        $form   = $this->createForm(new PrepotteryType($bucketid,$usid), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Prepottery entity.
     *
     * @Route("/{id}", name="prepottery_show")
     * @Breadcrumb("Show pottery",  route={"name"="prepottery_show", "parameters"={"id"}})
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KdigArchaeologicalBundle:Prepottery')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Prepottery entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Prepottery entity.
     *
     * @Route("/{id}/edit", name="prepottery_edit")
     * @Breadcrumb("Edit pottery",  route={"name"="prepottery_edit", "parameters"={"id"}})
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

        $entity = $em->getRepository('KdigArchaeologicalBundle:Prepottery')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Prepottery entity.');
        }

        $editForm = $this->createForm(new PrepotteryType($bucketid,null), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Prepottery entity.
     *
     * @Route("/{id}", name="prepottery_update")
     * @Method("PUT")
     * @Template("KdigArchaeologicalBundle:Prepottery:edit.html.twig")
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
        
        $entity = $em->getRepository('KdigArchaeologicalBundle:Prepottery')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Prepottery entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new PrepotteryType($bucketid,null), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.update.success');

            return $this->redirect($this->generateUrl('prepottery_edit', array('id' => $id)));
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
     * Deletes a Prepottery entity.
     *
     * @Route("/{id}/delete", name="prepottery_delete")
     *
     * @Secure(roles="ROLE_ARCHAEOLOGY , ROLE_ADMIN")
     */
    public function deleteAction(Request $request, $id)
    {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('KdigArchaeologicalBundle:Prepottery')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Prepottery entity.');
            }

            $em->remove($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.delete.success');

        return $this->redirect($this->generateUrl('prepottery'));
    }

    /**
     * Creates a form to delete a Prepottery entity by id.
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
     * Get a default text for Bucket from selected us.
     *
     * @Route("/getdefaulttext", name="kdig_prepottery_defaulttext", options={"expose"=true})
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
        $stringa = $em->getRepository('KdigArchaeologicalBundle:Prepottery')->freeName($bucket);
        
        return new Response($stringa);
    }
}
