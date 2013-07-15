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

use Kdig\OrientBundle\Entity\Potteryvoc\VocRim;
use Kdig\OrientBundle\Form\Potteryvoc\VocRimType;
use Kdig\OrientBundle\Form\Potteryvoc\VocRimFilterType;

/**
 * Potteryvoc\VocRim controller.
 *
 * @Route("/potteryvoc_vocrim")
 */
class VocRimController extends Controller
{
    /**
     * Lists all Potteryvoc\VocRim entities.
     *
     * @Route("/", name="potteryvoc_vocrim")
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
        $filterForm = $this->createForm(new Potteryvoc\VocRimFilterType());
        $em = $this->getDoctrine()->getManager();
        $queryBuilder = $em->getRepository('KdigOrientBundle:Potteryvoc\VocRim')->createQueryBuilder('e');

        // Reset filter
        if ($request->get('filter_action') == 'reset') {
            $session->remove('Potteryvoc\VocRimControllerFilter');
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
                $session->set('Potteryvoc\VocRimControllerFilter', $filterData);
            }
        } else {
            // Get filter from session
            if ($session->has('Potteryvoc\VocRimControllerFilter')) {
                $filterData = $session->get('Potteryvoc\VocRimControllerFilter');
                $filterForm = $this->createForm(new Potteryvoc\VocRimFilterType(), $filterData);
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
            return $me->generateUrl('potteryvoc_vocrim', array('page' => $page));
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
     * Creates a new Potteryvoc\VocRim entity.
     *
     * @Route("/", name="potteryvoc_vocrim_create")
     * @Method("POST")
     * @Template("KdigOrientBundle:Potteryvoc\VocRim:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new VocRim();
        $form = $this->createForm(new VocRimType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.create.success');

            return $this->redirect($this->generateUrl('potteryvoc_vocrim_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Potteryvoc\VocRim entity.
     *
     * @Route("/new", name="potteryvoc_vocrim_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new VocRim();
        $form   = $this->createForm(new VocRimType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Potteryvoc\VocRim entity.
     *
     * @Route("/{id}", name="potteryvoc_vocrim_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KdigOrientBundle:Potteryvoc\VocRim')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Potteryvoc\VocRim entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Potteryvoc\VocRim entity.
     *
     * @Route("/{id}/edit", name="potteryvoc_vocrim_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KdigOrientBundle:Potteryvoc\VocRim')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Potteryvoc\VocRim entity.');
        }

        $editForm = $this->createForm(new VocRimType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Potteryvoc\VocRim entity.
     *
     * @Route("/{id}", name="potteryvoc_vocrim_update")
     * @Method("PUT")
     * @Template("KdigOrientBundle:Potteryvoc\VocRim:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KdigOrientBundle:Potteryvoc\VocRim')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Potteryvoc\VocRim entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new VocRimType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.update.success');

            return $this->redirect($this->generateUrl('potteryvoc_vocrim_edit', array('id' => $id)));
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
     * Deletes a Potteryvoc\VocRim entity.
     *
     * @Route("/{id}", name="potteryvoc_vocrim_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('KdigOrientBundle:Potteryvoc\VocRim')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Potteryvoc\VocRim entity.');
            }

            $em->remove($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.delete.success');
        } else {
            $this->get('session')->getFlashBag()->add('error', 'flash.delete.error');
        }

        return $this->redirect($this->generateUrl('potteryvoc_vocrim'));
    }

    /**
     * Creates a form to delete a Potteryvoc\VocRim entity by id.
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
