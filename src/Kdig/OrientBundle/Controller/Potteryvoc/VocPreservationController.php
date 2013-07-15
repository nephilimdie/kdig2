<?php

namespace Kdig\OrientBundle\Controller\Potteryvoc;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\View\TwitterBootstrapView;

use Kdig\OrientBundle\Entity\Potteryvoc\VocPreservation;
use Kdig\OrientBundle\Form\Potteryvoc\VocPreservationType;
use Kdig\OrientBundle\Form\Potteryvoc\VocPreservationFilterType;

/**
 * Potteryvoc\VocPreservation controller.
 *
 * @Route("/potteryvoc_vocpreservation")
 */
class VocPreservationController extends Controller
{
    /**
     * Lists all Potteryvoc\VocPreservation entities.
     *
     * @Route("/", name="potteryvoc_vocpreservation")
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
        $filterForm = $this->createForm(new Potteryvoc\VocPreservationFilterType());
        $em = $this->getDoctrine()->getManager();
        $queryBuilder = $em->getRepository('KdigOrientBundle:Potteryvoc\VocPreservation')->createQueryBuilder('e');

        // Reset filter
        if ($request->get('filter_action') == 'reset') {
            $session->remove('Potteryvoc\VocPreservationControllerFilter');
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
                $session->set('Potteryvoc\VocPreservationControllerFilter', $filterData);
            }
        } else {
            // Get filter from session
            if ($session->has('Potteryvoc\VocPreservationControllerFilter')) {
                $filterData = $session->get('Potteryvoc\VocPreservationControllerFilter');
                $filterForm = $this->createForm(new Potteryvoc\VocPreservationFilterType(), $filterData);
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
            return $me->generateUrl('potteryvoc_vocpreservation', array('page' => $page));
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
     * Creates a new Potteryvoc\VocPreservation entity.
     *
     * @Route("/", name="potteryvoc_vocpreservation_create")
     * @Method("POST")
     * @Template("KdigOrientBundle:Potteryvoc\VocPreservation:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new VocPreservation();
        $form = $this->createForm(new VocPreservationType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.create.success');

            return $this->redirect($this->generateUrl('potteryvoc_vocpreservation_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Potteryvoc\VocPreservation entity.
     *
     * @Route("/new", name="potteryvoc_vocpreservation_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new VocPreservation();
        $form   = $this->createForm(new VocPreservationType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Potteryvoc\VocPreservation entity.
     *
     * @Route("/{id}", name="potteryvoc_vocpreservation_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KdigOrientBundle:Potteryvoc\VocPreservation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Potteryvoc\VocPreservation entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Potteryvoc\VocPreservation entity.
     *
     * @Route("/{id}/edit", name="potteryvoc_vocpreservation_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KdigOrientBundle:Potteryvoc\VocPreservation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Potteryvoc\VocPreservation entity.');
        }

        $editForm = $this->createForm(new VocPreservationType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Potteryvoc\VocPreservation entity.
     *
     * @Route("/{id}", name="potteryvoc_vocpreservation_update")
     * @Method("PUT")
     * @Template("KdigOrientBundle:Potteryvoc\VocPreservation:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KdigOrientBundle:Potteryvoc\VocPreservation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Potteryvoc\VocPreservation entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new VocPreservationType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.update.success');

            return $this->redirect($this->generateUrl('potteryvoc_vocpreservation_edit', array('id' => $id)));
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
     * Deletes a Potteryvoc\VocPreservation entity.
     *
     * @Route("/{id}", name="potteryvoc_vocpreservation_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('KdigOrientBundle:Potteryvoc\VocPreservation')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Potteryvoc\VocPreservation entity.');
            }

            $em->remove($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.delete.success');
        } else {
            $this->get('session')->getFlashBag()->add('error', 'flash.delete.error');
        }

        return $this->redirect($this->generateUrl('potteryvoc_vocpreservation'));
    }

    /**
     * Creates a form to delete a Potteryvoc\VocPreservation entity by id.
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
