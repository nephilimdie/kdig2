<?php

namespace Kdig\ArchaeologicalBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Kdig\ArchaeologicalBundle\Entity\VocUsType;
use Kdig\ArchaeologicalBundle\Form\VocUsTypeType;

/**
 * VocUsType controller.
 *
 * @Route("/vocustype")
 */
class VocUsTypeController extends Controller
{

    /**
     * Lists all VocUsType entities.
     *
     * @Route("/", name="vocustype")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('KdigArchaeologicalBundle:VocUsType')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new VocUsType entity.
     *
     * @Route("/", name="vocustype_create")
     * @Method("POST")
     * @Template("KdigArchaeologicalBundle:VocUsType:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new VocUsType();
        $form = $this->createForm(new VocUsTypeType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('vocustype_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new VocUsType entity.
     *
     * @Route("/new", name="vocustype_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new VocUsType();
        $form   = $this->createForm(new VocUsTypeType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a VocUsType entity.
     *
     * @Route("/{id}", name="vocustype_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KdigArchaeologicalBundle:VocUsType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find VocUsType entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing VocUsType entity.
     *
     * @Route("/{id}/edit", name="vocustype_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KdigArchaeologicalBundle:VocUsType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find VocUsType entity.');
        }

        $editForm = $this->createForm(new VocUsTypeType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing VocUsType entity.
     *
     * @Route("/{id}", name="vocustype_update")
     * @Method("PUT")
     * @Template("KdigArchaeologicalBundle:VocUsType:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KdigArchaeologicalBundle:VocUsType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find VocUsType entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new VocUsTypeType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('vocustype_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a VocUsType entity.
     *
     * @Route("/{id}", name="vocustype_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('KdigArchaeologicalBundle:VocUsType')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find VocUsType entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('vocustype'));
    }

    /**
     * Creates a form to delete a VocUsType entity by id.
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
