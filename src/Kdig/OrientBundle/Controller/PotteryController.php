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
use APY\DataGridBundle\Grid\Column\ActionsColumn;
use APY\DataGridBundle\Grid\Export\ExcelExport;

/**
 * Pottery controller.
 *
 * @Route("/pottery")
 */
class PotteryController extends Controller
{
    /**
     * Lists all Pottery entities.ì in grid
     *
     * @Route("/", name="object")
     * @Method("GET")
     */
    public function myGridAction()
    {
        $source = new Entity('KdigOrientBundle:Pottery');
        $grid = $this->get('grid');
        $grid->setSource($source);
        // Configuration of the grid
        // 
        // Create an Actions Column
        $actionsColumn = new ActionsColumn('info_column_1', 'Actions 1');
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
        
        // Manage the grid redirection, exports and the response of the controller
        return $grid->getGridResponse('KdigTemplateBundle:Default:grid.html.twig');
    }
    /**
     * Lists all Pottery entities.
     *
     * @Route("/", name="pottery")
     * @Method("GET")
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
     * @Route("/", name="pottery_create")
     * @Method("POST")
     * @Template("KdigOrientBundle:Pottery:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Pottery();
        $form = $this->createForm(new PotteryType(), $entity);
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
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Pottery();
        $form   = $this->createForm(new PotteryType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Pottery entity.
     *
     * @Route("/{id}", name="pottery_show")
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
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KdigOrientBundle:Pottery')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Pottery entity.');
        }

        $editForm = $this->createForm(new PotteryType(), $entity);
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
     * @Route("/{id}", name="pottery_update")
     * @Method("PUT")
     * @Template("KdigOrientBundle:Pottery:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KdigOrientBundle:Pottery')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Pottery entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new PotteryType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.update.success');

            return $this->redirect($this->generateUrl('pottery_edit', array('id' => $id)));
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
     * @Route("/{id}", name="pottery_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('KdigOrientBundle:Pottery')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Pottery entity.');
            }

            $em->remove($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.delete.success');
        } else {
            $this->get('session')->getFlashBag()->add('error', 'flash.delete.error');
        }

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
}
