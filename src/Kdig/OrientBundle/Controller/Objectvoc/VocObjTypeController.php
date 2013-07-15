<?php

namespace Kdig\OrientBundle\Controller\Objectvoc;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\View\TwitterBootstrapView;

use Kdig\OrientBundle\Entity\Objectvoc\VocObjType;
use Kdig\OrientBundle\Form\Objectvoc\VocObjTypeType;
use Kdig\OrientBundle\Form\Objectvoc\VocObjTypeFilterType;

/**
 * Objectvoc\VocObjType controller.
 *
 * @Route("/objectvoc_vocobjtype")
 */
class VocObjTypeController extends Controller
{
    /**
     * Lists all Objectvoc\VocObjType entities.
     *
     * @Route("/", name="objectvoc_vocobjtype")
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
        $filterForm = $this->createForm(new Objectvoc\VocObjTypeFilterType());
        $em = $this->getDoctrine()->getManager();
        $queryBuilder = $em->getRepository('KdigOrientBundle:Objectvoc\VocObjType')->createQueryBuilder('e');

        // Reset filter
        if ($request->get('filter_action') == 'reset') {
            $session->remove('Objectvoc\VocObjTypeControllerFilter');
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
                $session->set('Objectvoc\VocObjTypeControllerFilter', $filterData);
            }
        } else {
            // Get filter from session
            if ($session->has('Objectvoc\VocObjTypeControllerFilter')) {
                $filterData = $session->get('Objectvoc\VocObjTypeControllerFilter');
                $filterForm = $this->createForm(new Objectvoc\VocObjTypeFilterType(), $filterData);
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
            return $me->generateUrl('objectvoc_vocobjtype', array('page' => $page));
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
     * Creates a new Objectvoc\VocObjType entity.
     *
     * @Route("/", name="objectvoc_vocobjtype_create")
     * @Method("POST")
     * @Template("KdigOrientBundle:Objectvoc\VocObjType:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new VocObjType();
        $form = $this->createForm(new VocObjTypeType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.create.success');

            return $this->redirect($this->generateUrl('objectvoc_vocobjtype_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Objectvoc\VocObjType entity.
     *
     * @Route("/new", name="objectvoc_vocobjtype_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new VocObjType();
        $form   = $this->createForm(new VocObjTypeType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Objectvoc\VocObjType entity.
     *
     * @Route("/{id}", name="objectvoc_vocobjtype_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KdigOrientBundle:Objectvoc\VocObjType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Objectvoc\VocObjType entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Objectvoc\VocObjType entity.
     *
     * @Route("/{id}/edit", name="objectvoc_vocobjtype_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KdigOrientBundle:Objectvoc\VocObjType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Objectvoc\VocObjType entity.');
        }

        $editForm = $this->createForm(new VocObjTypeType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Objectvoc\VocObjType entity.
     *
     * @Route("/{id}", name="objectvoc_vocobjtype_update")
     * @Method("PUT")
     * @Template("KdigOrientBundle:Objectvoc\VocObjType:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KdigOrientBundle:Objectvoc\VocObjType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Objectvoc\VocObjType entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new VocObjTypeType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.update.success');

            return $this->redirect($this->generateUrl('objectvoc_vocobjtype_edit', array('id' => $id)));
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
     * Deletes a Objectvoc\VocObjType entity.
     *
     * @Route("/{id}", name="objectvoc_vocobjtype_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('KdigOrientBundle:Objectvoc\VocObjType')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Objectvoc\VocObjType entity.');
            }

            $em->remove($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.delete.success');
        } else {
            $this->get('session')->getFlashBag()->add('error', 'flash.delete.error');
        }

        return $this->redirect($this->generateUrl('objectvoc_vocobjtype'));
    }

    /**
     * Creates a form to delete a Objectvoc\VocObjType entity by id.
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
