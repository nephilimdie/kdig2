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

use Kdig\OrientBundle\Entity\Object;
use Kdig\OrientBundle\Form\ObjectType;
use Kdig\OrientBundle\Form\ObjectFilterType;

use APY\DataGridBundle\Grid\Source\Entity;
use APY\DataGridBundle\Grid\Action\RowAction;
use APY\DataGridBundle\Grid\Column\ActionsColumn;
use APY\DataGridBundle\Grid\Export\PHPExcel2007Export;

use Ddeboer\DataImport\Workflow;
use Ddeboer\DataImport\Source\Http;
use Ddeboer\DataImport\Source\Filter\Unzip;
use Ddeboer\DataImport\Reader\CsvReader;
use Ddeboer\DataImport\ValueConverter\DateTimeValueConverter;
/**
 * Object controller.
 *
 * @Route("/object")
 */
class ObjectController extends Controller
{
    /**
     * Lists all Object entities.ì in grid
     *
     * @Route("/", name="object")
     * @Method("GET")
     */
    public function myGridAction()
    {
        $source = new Entity('KdigOrientBundle:Object');
        $grid = $this->get('grid');
        $grid->setSource($source);
        // Configuration of the grid
        // 
        // Create an Actions Column
        $actionsColumn = new ActionsColumn('info_column_1', 'Actions');
        $actionsColumn->setSeparator("<br />");
        $grid->addColumn($actionsColumn, 1);

        // Attach a rowAction to the Actions Column
        $showAction = new RowAction('Show', 'pottery_show');
        $showAction->setColumn('info_column');
        $grid->addRowAction($showAction);
//        // OR add a second row action directly to a new action column
//        $rowAction2 = new RowAction('Edit', 'pottery_edit');
//        $actionsColumn2 = new ActionsColumn($column, $title, array(rowAction2), $separator);
//        $grid->addColumn($actionsColumn2, $position2);
        $fileName = 'pottery-'.date("d-m-Y");
        $export = new PHPExcel2007Export('Excel Pottery 2007 Export',$fileName, array(), 'UTF-8', 'ROLE_POTTERY');

        $export->objPHPExcel->getProperties()->setCreator("KdigProject");
        $export->objPHPExcel->getProperties()->setLastModifiedBy("KdigProject");
        $export->objPHPExcel->getProperties()->setTitle("KdigProject Document");
        $export->objPHPExcel->getProperties()->setSubject("KdigProject Document");
        $export->objPHPExcel->getProperties()->setDescription("KdigProject");
        $export->objPHPExcel->getProperties()->setKeywords("KdigProject");
        $export->objPHPExcel->getProperties()->setCategory("KdigProject");

        $grid->addExport($export);
        // Manage the grid redirection, exports and the response of the controller
        return $grid->getGridResponse('KdigTemplateBundle:Default:Grid/grid.html.twig');
    }
    /**
     * Lists all Object entities.
     *
     * @Template()
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
     * @Route("/", name="object_create")
     * @Method("POST")
     * @Template("KdigOrientBundle:Object:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Object();
        $form = $this->createForm(new ObjectType(), $entity);
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
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Object();
        $form   = $this->createForm(new ObjectType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Object entity.
     *
     * @Route("/{id}", name="object_show")
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
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KdigOrientBundle:Object')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Object entity.');
        }

        $editForm = $this->createForm(new ObjectType(), $entity);
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
     * @Route("/{id}", name="object_update")
     * @Method("PUT")
     * @Template("KdigOrientBundle:Object:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KdigOrientBundle:Object')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Object entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new ObjectType(), $entity);
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
     * @Route("/{id}", name="object_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('KdigOrientBundle:Object')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Object entity.');
            }

            $em->remove($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.delete.success');
        } else {
            $this->get('session')->getFlashBag()->add('error', 'flash.delete.error');
        }

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
     * @Route("/object_csv", name="object_csv")
     * @Method("GET")
     * @Template("KdigOrientBundle:Object:csv.html.twig")
     */
    public function importCSVAction() {
        
        $rootdir = $this->get('kernel')->getRootDir();
        // import data from old almadig systm to kdig
        $reader = new \EasyCSV\Reader($rootdir.'/../web/uploads/updaobject.csv');
        $csvarray = $reader->getAll();
        
        die(print_r($data));
    }
}
