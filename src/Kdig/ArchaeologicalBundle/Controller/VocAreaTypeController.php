<?php

namespace Kdig\ArchaeologicalBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Kdig\ArchaeologicalBundle\Entity\VocAreaType;
use Kdig\ArchaeologicalBundle\Form\VocAreaTypeType;

/**
 * VocAreaType controller.
 *
 * @Route("/vocareatype")
 */
class VocAreaTypeController extends Controller
{

    /**
     * Lists all VocAreaType entities.
     *
     * @Route("/", name="vocareatype")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('KdigArchaeologicalBundle:VocAreaType')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new VocAreaType entity.
     *
     * @Route("/", name="vocareatype_create")
     * @Method("POST")
     * @Template("KdigArchaeologicalBundle:VocAreaType:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new VocAreaType();
        $form = $this->createForm(new VocAreaTypeType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('vocareatype_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new VocAreaType entity.
     *
     * @Route("/new", name="vocareatype_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new VocAreaType();
        $form   = $this->createForm(new VocAreaTypeType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a VocAreaType entity.
     *
     * @Route("/{id}", name="vocareatype_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KdigArchaeologicalBundle:VocAreaType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find VocAreaType entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing VocAreaType entity.
     *
     * @Route("/{id}/edit", name="vocareatype_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KdigArchaeologicalBundle:VocAreaType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find VocAreaType entity.');
        }

        $editForm = $this->createForm(new VocAreaTypeType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing VocAreaType entity.
     *
     * @Route("/{id}", name="vocareatype_update")
     * @Method("PUT")
     * @Template("KdigArchaeologicalBundle:VocAreaType:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KdigArchaeologicalBundle:VocAreaType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find VocAreaType entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new VocAreaTypeType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('vocareatype_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a VocAreaType entity.
     *
     * @Route("/{id}", name="vocareatype_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('KdigArchaeologicalBundle:VocAreaType')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find VocAreaType entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('vocareatype'));
    }

    /**
     * Creates a form to delete a VocAreaType entity by id.
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
