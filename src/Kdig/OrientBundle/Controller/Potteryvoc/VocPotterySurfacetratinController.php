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

use Kdig\OrientBundle\Entity\Potteryvoc\VocPotterySurfacetratin;
use Kdig\OrientBundle\Form\Potteryvoc\VocPotterySurfacetratinType;
use Kdig\OrientBundle\Form\Potteryvoc\VocPotterySurfacetratinFilterType;

/**
 * Potteryvoc\VocPotterySurfacetratin controller.
 *
 * @Route("/potteryvoc_vocpotterysurfacetratin")
 */
class VocPotterySurfacetratinController extends Controller
{
    /**
     * Lists all Potteryvoc\VocPotterySurfacetratin entities.
     *
     * @Route("/", name="potteryvoc_vocpotterysurfacetratin")
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
        $filterForm = $this->createForm(new Potteryvoc\VocPotterySurfacetratinFilterType());
        $em = $this->getDoctrine()->getManager();
        $queryBuilder = $em->getRepository('KdigOrientBundle:Potteryvoc\VocPotterySurfacetratin')->createQueryBuilder('e');

        // Reset filter
        if ($request->get('filter_action') == 'reset') {
            $session->remove('Potteryvoc\VocPotterySurfacetratinControllerFilter');
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
                $session->set('Potteryvoc\VocPotterySurfacetratinControllerFilter', $filterData);
            }
        } else {
            // Get filter from session
            if ($session->has('Potteryvoc\VocPotterySurfacetratinControllerFilter')) {
                $filterData = $session->get('Potteryvoc\VocPotterySurfacetratinControllerFilter');
                $filterForm = $this->createForm(new Potteryvoc\VocPotterySurfacetratinFilterType(), $filterData);
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
            return $me->generateUrl('potteryvoc_vocpotterysurfacetratin', array('page' => $page));
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
     * Creates a new Potteryvoc\VocPotterySurfacetratin entity.
     *
     * @Route("/", name="potteryvoc_vocpotterysurfacetratin_create")
     * @Method("POST")
     * @Template("KdigOrientBundle:Potteryvoc\VocPotterySurfacetratin:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new VocPotterySurfacetratin();
        $form = $this->createForm(new VocPotterySurfacetratinType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.create.success');

            return $this->redirect($this->generateUrl('potteryvoc_vocpotterysurfacetratin_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Potteryvoc\VocPotterySurfacetratin entity.
     *
     * @Route("/new", name="potteryvoc_vocpotterysurfacetratin_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new VocPotterySurfacetratin();
        $form   = $this->createForm(new VocPotterySurfacetratinType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Potteryvoc\VocPotterySurfacetratin entity.
     *
     * @Route("/{id}", name="potteryvoc_vocpotterysurfacetratin_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KdigOrientBundle:Potteryvoc\VocPotterySurfacetratin')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Potteryvoc\VocPotterySurfacetratin entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Potteryvoc\VocPotterySurfacetratin entity.
     *
     * @Route("/{id}/edit", name="potteryvoc_vocpotterysurfacetratin_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KdigOrientBundle:Potteryvoc\VocPotterySurfacetratin')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Potteryvoc\VocPotterySurfacetratin entity.');
        }

        $editForm = $this->createForm(new VocPotterySurfacetratinType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Potteryvoc\VocPotterySurfacetratin entity.
     *
     * @Route("/{id}", name="potteryvoc_vocpotterysurfacetratin_update")
     * @Method("PUT")
     * @Template("KdigOrientBundle:Potteryvoc\VocPotterySurfacetratin:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KdigOrientBundle:Potteryvoc\VocPotterySurfacetratin')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Potteryvoc\VocPotterySurfacetratin entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new VocPotterySurfacetratinType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.update.success');

            return $this->redirect($this->generateUrl('potteryvoc_vocpotterysurfacetratin_edit', array('id' => $id)));
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
     * Deletes a Potteryvoc\VocPotterySurfacetratin entity.
     *
     * @Route("/{id}", name="potteryvoc_vocpotterysurfacetratin_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('KdigOrientBundle:Potteryvoc\VocPotterySurfacetratin')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Potteryvoc\VocPotterySurfacetratin entity.');
            }

            $em->remove($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.delete.success');
        } else {
            $this->get('session')->getFlashBag()->add('error', 'flash.delete.error');
        }

        return $this->redirect($this->generateUrl('potteryvoc_vocpotterysurfacetratin'));
    }

    /**
     * Creates a form to delete a Potteryvoc\VocPotterySurfacetratin entity by id.
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
