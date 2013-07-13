<?php

namespace Kdig\ArchaeologicalBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Kdig\ArchaeologicalBundle\Entity\Matrix;
use Kdig\ArchaeologicalBundle\Form\MatrixType;

/**
 * Matrix controller.
 *
 * @Route("/matrix")
 */
class MatrixController extends Controller
{

    /**
     * Lists all Matrix entities.
     *
     * @Route("/", name="matrix")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('KdigArchaeologicalBundle:Matrix')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Matrix entity.
     *
     * @Route("/", name="matrix_create")
     * @Method("POST")
     * @Template("KdigArchaeologicalBundle:Matrix:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Matrix();
        $form = $this->createForm(new MatrixType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('matrix_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Matrix entity.
     *
     * @Route("/new", name="matrix_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Matrix();
        $form   = $this->createForm(new MatrixType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Matrix entity.
     *
     * @Route("/{id}", name="matrix_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KdigArchaeologicalBundle:Matrix')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Matrix entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Matrix entity.
     *
     * @Route("/{id}/edit", name="matrix_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KdigArchaeologicalBundle:Matrix')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Matrix entity.');
        }

        $editForm = $this->createForm(new MatrixType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Matrix entity.
     *
     * @Route("/{id}", name="matrix_update")
     * @Method("PUT")
     * @Template("KdigArchaeologicalBundle:Matrix:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KdigArchaeologicalBundle:Matrix')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Matrix entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new MatrixType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('matrix_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Matrix entity.
     *
     * @Route("/{id}", name="matrix_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('KdigArchaeologicalBundle:Matrix')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Matrix entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('matrix'));
    }

    /**
     * Creates a form to delete a Matrix entity by id.
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
