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

use Kdig\ArchaeologicalBundle\Entity\Presample;
use Kdig\ArchaeologicalBundle\Form\PresampleType;
use Kdig\ArchaeologicalBundle\Form\PresampleFilterType;

/**
 * Presample controller.
 *
 * @Route("/presample")
 */
class PresampleController extends Controller
{
    /**
     * Lists all Presample entities.
     *
     * @Route("/", name="presample")
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
        $filterForm = $this->createForm(new PresampleFilterType());
        $em = $this->getDoctrine()->getManager();
        $queryBuilder = $em->getRepository('KdigArchaeologicalBundle:Presample')->createQueryBuilder('e');

        // Reset filter
        if ($request->get('filter_action') == 'reset') {
            $session->remove('PresampleControllerFilter');
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
                $session->set('PresampleControllerFilter', $filterData);
            }
        } else {
            // Get filter from session
            if ($session->has('PresampleControllerFilter')) {
                $filterData = $session->get('PresampleControllerFilter');
                $filterForm = $this->createForm(new PresampleFilterType(), $filterData);
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
            return $me->generateUrl('presample', array('page' => $page));
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
     * Creates a new Presample entity.
     *
     * @Route("/", name="presample_create")
     * @Method("POST")
     * @Template("KdigArchaeologicalBundle:Presample:new.html.twig")
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
        
        $entity  = new Presample();
        $form = $this->createForm(new PresampleType($bucketid,$usid), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.create.success');

            return $this->redirect($this->generateUrl('presample_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Presample entity.
     *
     * @Route("/new", name="presample_new")
     * @Method("GET")
     * @Template()
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
        
        $entity = new Presample();
        $form   = $this->createForm(new PresampleType($bucketid,$usid), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Presample entity.
     *
     * @Route("/{id}", name="presample_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KdigArchaeologicalBundle:Presample')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Presample entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Presample entity.
     *
     * @Route("/{id}/edit", name="presample_edit")
     * @Method("GET")
     * @Template()
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

        $entity = $em->getRepository('KdigArchaeologicalBundle:Presample')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Presample entity.');
        }

        $editForm = $this->createForm(new PresampleType($bucketid,null), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Presample entity.
     *
     * @Route("/{id}", name="presample_update")
     * @Method("PUT")
     * @Template("KdigArchaeologicalBundle:Presample:edit.html.twig")
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
        
        $entity = $em->getRepository('KdigArchaeologicalBundle:Presample')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Presample entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new PresampleType($bucketid,null), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.update.success');

            return $this->redirect($this->generateUrl('presample_edit', array('id' => $id)));
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
     * Deletes a Presample entity.
     *
     * @Route("/{id}", name="presample_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('KdigArchaeologicalBundle:Presample')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Presample entity.');
            }

            $em->remove($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.delete.success');
        } else {
            $this->get('session')->getFlashBag()->add('error', 'flash.delete.error');
        }

        return $this->redirect($this->generateUrl('presample'));
    }

    /**
     * Creates a form to delete a Presample entity by id.
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
     * @Route("/getdefaulttext", name="kdig_presample_defaulttext", options={"expose"=true})
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
        $stringa = $em->getRepository('KdigArchaeologicalBundle:Presample')->freeName($bucket);
        
        return new Response($stringa);
    }
}
