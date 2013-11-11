<?php

namespace Kdig\OrientBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\View\TwitterBootstrapView;

use Kdig\OrientBundle\Entity\Pottery;
use Kdig\OrientBundle\Form\PotteryType;
use Kdig\OrientBundle\Form\PotteryFilterType;

use APY\DataGridBundle\Grid\Source\Entity;
use APY\DataGridBundle\Grid\Action\RowAction;
use APY\DataGridBundle\Grid\Action\MassAction;
use APY\DataGridBundle\Grid\Action\DeleteMassAction;
use APY\DataGridBundle\Grid\Column\ActionsColumn;
use APY\DataGridBundle\Grid\Export\PHPExcel2007Export;

use APY\BreadcrumbTrailBundle\Annotation\Breadcrumb;

use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\HttpFoundation\Response;

/**
 * Pottery controller.
 *
 * @Route("/pottery")
 * @Breadcrumb("Pottery", route="pottery")
 */
class PotteryController extends Controller
{
    /**
     * Lists all Pottery entities.ì in grid
     *
     * @Route("/", name="pottery")
     * @Breadcrumb("Table", route="pottery")
     * @Template("KdigTemplateBundle:Default:Grid/grid.html.twig")
     * @Secure(roles="ROLE_ARCHAEOLOGY, ROLE_ADMIN, ROLE_POTTERY, ROLE_SAMPLE, ROLE_OBJECT")
     */
    public function myGridAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();
        
        $source = new Entity('KdigOrientBundle:Pottery');
        $grid = $this->get('grid');
        $grid->setSource($source);

        $grid->setDefaultOrder('prepottery.name', 'asc');

        $actionsColumn = new ActionsColumn('info_column_1', 'Actions');
        $actionsColumn->setSeparator("<br />");
        $grid->addColumn($actionsColumn, 1);
        $showAction = new RowAction('Show', 'pottery_show');
        $showAction->setColumn('info_column');
        
        $rowAction2 = new RowAction('Edit', 'pottery_edit', false, '_self', array('class' => 'grid_edit_action'));
        $grid->addRowAction($rowAction2);
        
        $grid->addRowAction($showAction);
        $grid->addMassAction(new DeleteMassAction());
        
        
//        $tableAlias = $source::TABLE_ALIAS;
//        $source->manipulateQuery(function ($query) use ($tableAlias) {
//            $query->addSelect('array_to_string(array_agg(projects.name), ',')) as points');
//        });
//
//        $grid->addColumn(new BlankColumn(['id' => 'points', 'title' => 'points','size' => '30']));
        
        $fileName = 'Pottery-'.date("d-m-Y");
        
        $export = new PHPExcel2007Export('Excel 2007', $fileName, array(), 'UTF-8', 'ROLE_POTTERY');

        $export->objPHPExcel->getProperties()->setCreator("KdigProject ".$user);
        $export->objPHPExcel->getProperties()->setLastModifiedBy("KdigProject");
        $export->objPHPExcel->getProperties()->setTitle("KdigProject ".$fileName);
        $export->objPHPExcel->getProperties()->setSubject("KdigProject Document");
        $export->objPHPExcel->getProperties()->setDescription("KdigProject");
        $export->objPHPExcel->getProperties()->setKeywords("KdigProject");
        $export->objPHPExcel->getProperties()->setCategory("KdigProject");
        
        //$grid->addExport($export);
        
        // Manage the grid redirection, exports and the response of the controller
        return $grid->getGridResponse('KdigTemplateBundle:Default:Grid\grid.html.twig');
    }
    /**
     * Lists all Pottery entities.
     *
     * @Route("/home/", name="pottery_home")
     * @Breadcrumb("Pottery Home", route="pottery_home")
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
        $filterForm = $this->createForm(new PotteryFilterType());
        $em = $this->getDoctrine()->getManager();
        $queryBuilder = $em->getRepository('KdigOrientBundle:Pottery')->createQueryBuilder('e');

        // Reset filter
        if ($request->get('filter_action') == 'reset') {
            $session->remove('PotteryControllerFilter');
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
                $session->set('PotteryControllerFilter', $filterData);
            }
        } else {
            // Get filter from session
            if ($session->has('PotteryControllerFilter')) {
                $filterData = $session->get('PotteryControllerFilter');
                $filterForm = $this->createForm(new PotteryFilterType(), $filterData);
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
            return $me->generateUrl('pottery', array('page' => $page));
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
     * Creates a new Pottery entity.
     *
     * @Route("/pottery_create/", name="pottery_create")
     * @Method("POST")
     * @Template("KdigOrientBundle:Pottery:new.html.twig")
     * @Secure(roles="ROLE_POTTERY , ROLE_ADMIN")
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
        
        $entity  = new Pottery();
        $form   = $this->createForm(new PotteryType($bucketid, $usid), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.create.success');

            return $this->redirect($this->generateUrl('pottery_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Pottery entity.
     *
     * @Route("/new", name="pottery_new")
     * @Breadcrumb("New bucket", route="pottery_new")
     * @Template()
     * @Secure(roles="ROLE_POTTERY , ROLE_ADMIN")
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
        
        $entity = new Pottery();
        $form   = $this->createForm(new PotteryType($bucketid, $usid), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Pottery entity.
     *
     * @Route("/{id}/show", name="pottery_show")
     * @Breadcrumb("Show pottery {id}",  route={"name"="pottery_show", "parameters"={"id"}})
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KdigOrientBundle:Pottery')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Pottery entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Pottery entity.
     *
     * @Route("/{id}/edit", name="pottery_edit")
     * @Breadcrumb("Edit pottery",  route={"name"="pottery_edit", "parameters"={"id"}})
     * @Method("GET")
     * @Template()
     * @Secure(roles="ROLE_POTTERY , ROLE_ADMIN")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.context')->getToken()->getUser();
        $bucketid = null;
        
        if ($bucketid==null || $bucketid=='')
            $bucketid = $em->getRepository('KdigOrientBundle:Bucket')->getmygroupelement($user);

        $entity = $em->getRepository('KdigOrientBundle:Pottery')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Pottery entity.');
        }

        $editForm = $this->createForm(new PotteryType($bucketid,null), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Pottery entity.
     *
     * @Route("/{id}/update", name="pottery_update")
     * @Method("PUT")
     * @Template("KdigOrientBundle:Pottery:edit.html.twig")
     * @Secure(roles="ROLE_POTTERY , ROLE_ADMIN")
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

        $entity = $em->getRepository('KdigOrientBundle:Pottery')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Pottery entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new PotteryType($bucketid,null), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.update.success');

            return $this->redirect($this->generateUrl('pottery_show', array('id' => $id)));
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
     * Deletes a Pottery entity.
     *
     * @Route("/{id}/delete", name="pottery_delete")
     * @Secure(roles="ROLE_POTTERY , ROLE_ADMIN")
     */
    public function deleteAction(Request $request, $id)
    {
//        $form = $this->createDeleteForm($id);
//        $form->bind($request);
//
//        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('KdigOrientBundle:Pottery')->find($id);
            
            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Pottery entity.');
            }
            $prepottery = $entity->getPrepottery();
            $prepottery->setPottery(null);
            $entity->setPrepottery(null);
            $em->persist($entity);
            $em->persist($prepottery);
            $em->flush();
            $em->remove($prepottery);
            $em->remove($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.delete.success');
//        } else {
//            $this->get('session')->getFlashBag()->add('error', 'flash.delete.error');
//        }

        return $this->redirect($this->generateUrl('pottery'));
    }

    /**
     * Creates a form to delete a Pottery entity by id.
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
     * Download Pottery entity.
     *
     * @Route("/download", name="pottery_download")
     * @Template("KdigOrientBundle:Pottery:edit.html.twig")
     */
    public function downloadListAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('KdigOrientBundle:Pottery')->findAll();
        $objPHPExcel = new \PHPExcel();
        $fileName = 'Pottery-'.date("d-m-Y");

        $user = $this->get('security.context')->getToken()->getUser();
        $objPHPExcel->getProperties()->setCreator("KdigProject ".$user);
        $objPHPExcel->getProperties()->setLastModifiedBy("KdigProject");
        $objPHPExcel->getProperties()->setTitle("KdigProject ".$fileName);
        $objPHPExcel->getProperties()->setSubject("KdigProject Document");
        $objPHPExcel->getProperties()->setDescription("KdigProject");
        $objPHPExcel->getProperties()->setKeywords("KdigProject");
        $objPHPExcel->getProperties()->setCategory("KdigProject");
        
	$col = 0;
	$row = 0;
        
        $objPHPExcel->setActiveSheetIndex(0);
        $row++;
        
	$title = array(
	        'Area',
                'US',
	        'Name',
                'Type of context',
                'TCode',
	        'Classe',
	        'Shape',
                'Rim',
                'Neck',
                'Wall',
                'Upper Wall',
                'Lower Wall',
                'Base',
                'Handle',
                'Handle Position',
                'Spout',
                'Spout Position',
	        'Preservation',
	        'Technique',
	        'Inclusions',
	        'Inclusions Size',
	        'Inclusions Frequency',
	        'Inner Surface Treatment In',	        
	        'Inner Surface Treatment Out',	        
	        'Inner Surface Treatment In&Out',
	        'Decoration In',	        
	        'Decoration Out',	        
	        'Decoration In&Out',	 
                'Remarks',
	        'Firing',
	        'Outer color',
	        'Inner color',
	        'Fabric color',
	        'Rim Diameter',	        
	        'Rim width',	       
	        'Wall width',
                'Max wall diameter', 	        
	        'Botton width',	    	        
	        'Botton Height',	        
	        'Base of diameter',	        
	        'Restored',	        
	        'Datation',	        
	        'Created at'
	);  	
        
	foreach($title as $oggetto1)
	{
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $oggetto1);
            $col++;
	}
	
	$objPHPExcel->getActiveSheet()->setAutoFilter('A1:AH1');
	$row++;
        
	foreach($entities as $oggetto) {
            $col=0;
            //die($oggetto->getPrepottery()->getBucket()->getUs());
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, '{$oggetto->getPrepottery()->getBucket()->getUs()->getArea()}'); $col++;
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, ''.$oggetto->getPrepottery()->getBucket()); $col++;
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, ''.$oggetto->getPrepottery()->getName()); $col++;
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, ''.$oggetto->getTypecontext()); $col++;
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, ''.$oggetto->getTcode()); $col++;
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, ''.$oggetto->getClass()); $col++;
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, ''.$oggetto->getShape()); $col++;
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, ''.$oggetto->getRim()); $col++;
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, ''.$oggetto->getNeck()); $col++;
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, ''.$oggetto->getWall()); $col++;
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, ''.$oggetto->getUpperwall()); $col++;
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, ''.$oggetto->getLowerwall()); $col++;
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, ''.$oggetto->getBase()); $col++;
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, ''.$oggetto->getHandle()); $col++;
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, ''.$oggetto->getHandleposition()); $col++;
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, ''.$oggetto->getSpout()); $col++;
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, ''.$oggetto->getSpoutposition()); $col++;
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, ''.$oggetto->getPreservation()); $col++;
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, ''.$oggetto->getTechnique()); $col++;
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, ''.$oggetto->getInclusion()); $col++;
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, ''.$oggetto->getInclusionsize()); $col++;
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, ''.$oggetto->getInclusionfrequency()); $col++;

            $text = '';
            $i=0;
            foreach ($oggetto->getSurfacetratin() as $i => $varia) {
                $text .= $varia->getVocsurfacetratoption().'-'.$varia->getColor().'\n ';
            }
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $text);
            $text = ' ';
            $col++;
            foreach ($oggetto->getSurfacetratout() as $i => $varia) {
                $text .= $varia->getVocsurfacetratoption().' '.$varia->getColor().'\n ';
            }
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $text);
            $text = ' ';
            $col++;
            foreach ($oggetto->getSurfacetratinout() as $i => $varia) {
                $text .= $varia->getVocsurfacetratoption().' '.$varia->getColor().'\n ';
            }
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $text);
            $text = ' ';
            $col++;
            foreach ($oggetto->getPotdecorationin() as $varia) {
                $text .= $varia->getDecorationoption().' '.$varia->getColor().'\n ';
                //$surf = Doctrine_Core::getTable('ADSurfacetratmentoption')->find(array($varia->getSurfacetratmentoptionId()));
                //$text .= $surf.' '.$varia->getColor()->getName().' ';
            }
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $text);
            $text = ' ';
            $col++;
            foreach ($oggetto->getPotdecorationout() as $varia) {
                $text .= $varia->getDecorationoption().' '.$varia->getColor().'\n ';
                //$surf = Doctrine_Core::getTable('ADSurfacetratmentoption')->find(array($varia->getSurfacetratmentoptionId()));
                //$text .= $surf.' '.$varia->getColor()->getName().' ';
            }
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $text);
            $text = ' ';
            $col++;
            foreach ($oggetto->getPotdecorationinout() as $varia) {
                $text .= $varia->getDecorationoption().' '.$varia->getColor().'\n';
                //$surf = Doctrine_Core::getTable('ADSurfacetratmentoption')->find(array($varia->getSurfacetratmentoptionId()));
                //$text .= $surf.' '.$varia->getColor()->getName().' ';
            }
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $text);
            $col++;
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $oggetto->getRemarks()); $col++;
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, ''.$oggetto->getFiring()); $col++;
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $oggetto->getOuterColor()); $col++;
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $oggetto->getInnerColor()); $col++;
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $oggetto->getFabricColor()); $col++;
            
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $oggetto->getRimdiameter()); $col++;
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $oggetto->getRimWidth()); $col++;
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $oggetto->getMaxwalldiameter()); $col++;
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $oggetto->getWallwidth()); $col++;
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $oggetto->getMaxwalldiameter()); $col++;
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $oggetto->getBottomwidth()); $col++;
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $oggetto->getHeight()); $col++;
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $oggetto->getBasediameter()); $col++;
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $oggetto->getDatation()); $col++;
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $oggetto->getRestored()); $col++;
            //$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, ''.$oggetto->getCreated()); $col++;
            $row++;
	}
        $pseudoname = "/tmp/test_xls.xlsx";
	$objWriter = new \PHPExcel_Writer_Excel2007($objPHPExcel);
        $objWriter->save($pseudoname);

        $content = file_get_contents($pseudoname);
        $headers = array(
            'Content-Description' => 'File Transfer',
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => sprintf('attachment; filename="%s"', $fileName.'.xlsx'),
            'Content-Transfer-Encoding' => 'binary'
        );

        $response = new Response($content, 200, $headers);
        $response->setCharset('charset=utf-8');
        $response->expire();

        return $response;
        
        
        
    }
}
