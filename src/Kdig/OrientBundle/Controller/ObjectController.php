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

use Kdig\OrientBundle\Entity\Object;
use Kdig\OrientBundle\Form\ObjectType;
use Kdig\OrientBundle\Form\ObjectFilterType;
use Kdig\ArchaeologicalBundle\Entity\Preobject;

use APY\DataGridBundle\Grid\Source\Entity;
use APY\DataGridBundle\Grid\Action\RowAction;
use APY\DataGridBundle\Grid\Action\MassAction;
use APY\DataGridBundle\Grid\Action\DeleteMassAction;
use APY\DataGridBundle\Grid\Column\ActionsColumn;
use APY\DataGridBundle\Grid\Export\PHPExcel2007Export;

use APY\BreadcrumbTrailBundle\Annotation\Breadcrumb;

use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * Object controller.
 *
 * @Route("/object")
 * @Breadcrumb("Object", route="object")
 */
class ObjectController extends Controller
{
    /**
     * Lists all Object entities.ì in grid
     *
     * @Route("/", name="object")
     * @Breadcrumb("Table", route="object")
     * @Template("KdigTemplateBundle:Default:Grid/grid.html.twig")
     */
    public function myGridAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();
        
        $source = new Entity('KdigOrientBundle:Object');
        $grid = $this->get('grid');
        $grid->setSource($source);

        $grid->setDefaultOrder('number', 'asc');

        $actionsColumn = new ActionsColumn('info_column_1', 'Actions');
        $actionsColumn->setSeparator("<br />");
        $grid->addColumn($actionsColumn, 1);
        $showAction = new RowAction('Show', 'object_show');
        $showAction->setColumn('info_column');
        $grid->addRowAction($showAction);
        $grid->addMassAction(new DeleteMassAction());
        
        $fileName = 'object-'.date("d-m-Y");
        $export = new PHPExcel2007Export('Excel 2007',$fileName, array(), 'UTF-8', 'ROLE_OBJECT');

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
     * Lists all Object entities.
     *
     * @Route("/home/", name="object_home")
     * @Breadcrumb("Object Home", route="object_home")
     * @Template()
     * @Secure(roles="ROLE_OBJECT , ROLE_ADMIN")
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
        $filterForm = $this->createForm(new ObjectFilterType());
        $em = $this->getDoctrine()->getManager();
        $queryBuilder = $em->getRepository('KdigOrientBundle:Object')->createQueryBuilder('e');

        // Reset filter
        if ($request->get('filter_action') == 'reset') {
            $session->remove('ObjectControllerFilter');
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
                $session->set('ObjectControllerFilter', $filterData);
            }
        } else {
            // Get filter from session
            if ($session->has('ObjectControllerFilter')) {
                $filterData = $session->get('ObjectControllerFilter');
                $filterForm = $this->createForm(new ObjectFilterType(), $filterData);
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
            return $me->generateUrl('object', array('page' => $page));
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
     * Creates a new Object entity.
     *
     * @Route("/object_create/", name="object_create")
     * @Method("POST")
     * @Template("KdigOrientBundle:Object:new.html.twig")
     * @Secure(roles="ROLE_OBJECT , ROLE_ADMIN")
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
        
        $entity  = new Object();
        $form = $this->createForm(new ObjectType($bucketid,$usid), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.create.success');

            return $this->redirect($this->generateUrl('object_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Object entity.
     *
     * @Route("/new", name="object_new")
     * @Breadcrumb("New object", route="object_new")
     * @Template()
     * @Secure(roles="ROLE_OBJECT , ROLE_ADMIN")
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
        
        $entity = new Object();
        $form   = $this->createForm(new ObjectType($bucketid,$usid), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Object entity.
     *
     * @Route("/{id}/show", name="object_show")
     * @Breadcrumb("Show object",  route={"name"="object_show", "parameters"={"id"}})
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KdigOrientBundle:Object')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Object entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Object entity.
     *
     * @Route("/{id}/edit", name="object_edit")
     * @Breadcrumb("Edit object",  route={"name"="object_edit", "parameters"={"id"}})
     * @Method("GET")
     * @Template()
     * @Secure(roles="ROLE_OBJECT , ROLE_ADMIN")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.context')->getToken()->getUser();
        $bucketid = null;
        
        if ($bucketid==null || $bucketid=='')
            $bucketid = $em->getRepository('KdigOrientBundle:Bucket')->getmygroupelement($user);
        
        $entity = $em->getRepository('KdigOrientBundle:Object')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Object entity.');
        }

        $editForm = $this->createForm(new ObjectType($bucketid,null), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Object entity.
     *
     * @Route("/{id}/update", name="object_update")
     * @Method("PUT")
     * @Template("KdigOrientBundle:Object:edit.html.twig")
     * @Secure(roles="ROLE_OBJECT , ROLE_ADMIN")
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

        $entity = $em->getRepository('KdigOrientBundle:Object')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Object entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new ObjectType($bucketid,null), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.update.success');

            return $this->redirect($this->generateUrl('object_edit', array('id' => $id)));
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
     * Deletes a Object entity.
     *
     * @Route("/{id}/delete", name="object_delete")
     *
     * @Secure(roles="ROLE_OBJECT , ROLE_ADMIN")
     */
    public function deleteAction(Request $request, $id)
    {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('KdigOrientBundle:Object')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Object entity.');
            }

            $em->remove($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.delete.success');

        return $this->redirect($this->generateUrl('object'));
    }

    /**
     * Creates a form to delete a Object entity by id.
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
     *
     * @Route("/object_csv/", name="object_csv")
     * @Method("GET")
     * @Template("KdigOrientBundle:Object:csv.html.twig")
     * @Secure(roles="ROLE_OBJECT , ROLE_ADMIN")
     */
    public function importcsvAction() {
        /*
         */
        $rootdir = $this->get('kernel')->getRootDir();
        // import data from old almadig systm to kdig
        $reader = new \EasyCSV\Reader($rootdir.'/../web/uploads/updaobject.csv');
        $csvarray = $reader->getAll();
        
//        die(print_r($csvarray));
        $vectBucketExist = array();
        $vectBucketExist = array();
        $i=0; 
        $em = $this->getDoctrine()->getEntityManager();
        
        foreach($csvarray as $csvus) {
            $preObject = New Preobject();
            $preObject->setName($csvus['BUCKET']);
            $preObject->setIsPublic(false);
            $preObject->setIsActive(true);
            $preObject->setIsDelete(false);
            //find or add US
            //$csvus['CAMPAGNA']
            //$csvus['LOCUS']
            //$oldnameUS = 
            //$newbucketname = $em->getRepository('KdigOrientBundle:Bucket')->findOneByName($bucketname);
            //find or add bucket
            $oldnamebucket = substr_replace($csvus['BUCKET'] ,"",-2);
            $newbucketname = str_pad($oldnamebucket, 4 , "0000", STR_PAD_LEFT);
            $bucketname = 'KH.12.P.'.$newbucketname;
            
            $bucket = $em->getRepository('KdigOrientBundle:Bucket')->findOneByName($bucketname);
            $preObject->setBucket($bucket);
            
            $em->persist($preObject);
            $em->flush();

            $Object = New Object();
            $Object ->setNumber($csvus['NUM']);
            $Object ->setWeight($csvus['WEIGHT']);
            $Object ->setFragments($csvus['FRAGMENTS']);
            $Object ->setHeight($csvus['HEIGHT']);
            $Object ->setLenght($csvus['LENGHT']);
            $Object ->setWidth($csvus['WIDTH']);
            $Object ->setThickness($csvus['THICKNESS']);
            $Object ->setDiameter($csvus['DIAMETER']);
            $Object ->setPerforationdiameter($csvus['PERF. DIAM.']);
            $Object ->setRemarks($csvus['DESCRIPTION']);

            $Object ->setPreobject($preObject);
            if($csvus['MATERIAL'] != '') {
                $material = $em->getRepository('KdigOrientBundle:Objectvoc\VocObjMaterial')->checkAndAdd($csvus['MATERIAL']);
                $Object->setMaterial($material);
            }
            if($csvus['DECORATION'] != ''){
                $decoration = $em->getRepository('KdigOrientBundle:Objectvoc\VocObjDecoration')->checkAndAdd($csvus['DECORATION']);
                $Object->setDecoration($decoration);
            }
            if($csvus['PRESERVATION'] != ''){
                $preservation = $em->getRepository('KdigOrientBundle:Objectvoc\VocObjPreservation')->checkAndAdd($csvus['PRESERVATION']);
                $Object->setPreservation($preservation);
            }
            if($csvus['TECHNIQUE'] != ''){
                $technique = $em->getRepository('KdigOrientBundle:Objectvoc\VocObjTechnique')->checkAndAdd($csvus['TECHNIQUE']);
                $Object->setTechnique($technique);
            }
            if($csvus['TYPE'] != ''){
                $type = $em->getRepository('KdigOrientBundle:Objectvoc\VocObjType')->checkAndAdd($csvus['TYPE']);
                $Object->setType($type);
            }
            if($csvus['CLASS'] != ''){
                $class = $em->getRepository('KdigOrientBundle:Objectvoc\VocObjClass')->checkAndAdd($csvus['CLASS']);
                $Object->setClass($class);
            }

            $em->persist($Object);
            $em->flush();
            $i++;
        }
        
        return array();
    }
}
