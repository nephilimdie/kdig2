<?php

namespace Kdig\ArchaeologicalBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Kdig\ArchaeologicalBundle\Entity\VocRelation;
use Kdig\ArchaeologicalBundle\Form\VocRelationType;

/**
 * VocRelation controller.
 *
 * @Route("/vocrelation")
 */
class VocRelationController extends Controller
{

    /**
     * Lists all VocRelation entities.
     *
     * @Route("/", name="vocrelation")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('KdigArchaeologicalBundle:VocRelation')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new VocRelation entity.
     *
     * @Route("/", name="vocrelation_create")
     * @Method("POST")
     * @Template("KdigArchaeologicalBundle:VocRelation:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new VocRelation();
        $form = $this->createForm(new VocRelationType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('vocrelation_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new VocRelation entity.
     *
     * @Route("/new", name="vocrelation_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new VocRelation();
        $form   = $this->createForm(new VocRelationType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a VocRelation entity.
     *
     * @Route("/{id}", name="vocrelation_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KdigArchaeologicalBundle:VocRelation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find VocRelation entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing VocRelation entity.
     *
     * @Route("/{id}/edit", name="vocrelation_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KdigArchaeologicalBundle:VocRelation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find VocRelation entity.');
        }

        $editForm = $this->createForm(new VocRelationType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing VocRelation entity.
     *
     * @Route("/{id}", name="vocrelation_update")
     * @Method("PUT")
     * @Template("KdigArchaeologicalBundle:VocRelation:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KdigArchaeologicalBundle:VocRelation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find VocRelation entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new VocRelationType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('vocrelation_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a VocRelation entity.
     *
     * @Route("/{id}", name="vocrelation_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('KdigArchaeologicalBundle:VocRelation')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find VocRelation entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('vocrelation'));
    }

    /**
     * Creates a form to delete a VocRelation entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
