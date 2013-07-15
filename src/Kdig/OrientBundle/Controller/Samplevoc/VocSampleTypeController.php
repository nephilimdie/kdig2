<?php

namespace Kdig\OrientBundle\Controller\Samplevoc;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\View\TwitterBootstrapView;

use Kdig\OrientBundle\Entity\Samplevoc\VocSampleType;
use Kdig\OrientBundle\Form\Samplevoc\VocSampleTypeType;
use Kdig\OrientBundle\Form\Samplevoc\VocSampleTypeFilterType;

/**
 * Samplevoc\VocSampleType controller.
 *
 * @Route("/samplevoc_vocsampletype")
 */
class VocSampleTypeController extends Controller
{
    /**
     * Lists all Samplevoc\VocSampleType entities.
     *
     * @Route("/", name="samplevoc_vocsampletype")
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
        $filterForm = $this->createForm(new Samplevoc\VocSampleTypeFilterType());
        $em = $this->getDoctrine()->getManager();
        $queryBuilder = $em->getRepository('KdigOrientBundle:Samplevoc\VocSampleType')->createQueryBuilder('e');

        // Reset filter
        if ($request->get('filter_action') == 'reset') {
            $session->remove('Samplevoc\VocSampleTypeControllerFilter');
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
                $session->set('Samplevoc\VocSampleTypeControllerFilter', $filterData);
            }
        } else {
            // Get filter from session
            if ($session->has('Samplevoc\VocSampleTypeControllerFilter')) {
                $filterData = $session->get('Samplevoc\VocSampleTypeControllerFilter');
                $filterForm = $this->createForm(new Samplevoc\VocSampleTypeFilterType(), $filterData);
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
            return $me->generateUrl('samplevoc_vocsampletype', array('page' => $page));
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
     * Creates a new Samplevoc\VocSampleType entity.
     *
     * @Route("/", name="samplevoc_vocsampletype_create")
     * @Method("POST")
     * @Template("KdigOrientBundle:Samplevoc\VocSampleType:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new VocSampleType();
        $form = $this->createForm(new VocSampleTypeType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.create.success');

            return $this->redirect($this->generateUrl('samplevoc_vocsampletype_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Samplevoc\VocSampleType entity.
     *
     * @Route("/new", name="samplevoc_vocsampletype_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new VocSampleType();
        $form   = $this->createForm(new VocSampleTypeType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Samplevoc\VocSampleType entity.
     *
     * @Route("/{id}", name="samplevoc_vocsampletype_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KdigOrientBundle:Samplevoc\VocSampleType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Samplevoc\VocSampleType entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Samplevoc\VocSampleType entity.
     *
     * @Route("/{id}/edit", name="samplevoc_vocsampletype_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KdigOrientBundle:Samplevoc\VocSampleType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Samplevoc\VocSampleType entity.');
        }

        $editForm = $this->createForm(new VocSampleTypeType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Samplevoc\VocSampleType entity.
     *
     * @Route("/{id}", name="samplevoc_vocsampletype_update")
     * @Method("PUT")
     * @Template("KdigOrientBundle:Samplevoc\VocSampleType:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KdigOrientBundle:Samplevoc\VocSampleType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Samplevoc\VocSampleType entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new VocSampleTypeType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.update.success');

            return $this->redirect($this->generateUrl('samplevoc_vocsampletype_edit', array('id' => $id)));
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
     * Deletes a Samplevoc\VocSampleType entity.
     *
     * @Route("/{id}", name="samplevoc_vocsampletype_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('KdigOrientBundle:Samplevoc\VocSampleType')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Samplevoc\VocSampleType entity.');
            }

            $em->remove($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.delete.success');
        } else {
            $this->get('session')->getFlashBag()->add('error', 'flash.delete.error');
        }

        return $this->redirect($this->generateUrl('samplevoc_vocsampletype'));
    }

    /**
     * Creates a form to delete a Samplevoc\VocSampleType entity by id.
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
