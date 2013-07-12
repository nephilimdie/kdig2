<?php

namespace Kdig\ArchaeologicalBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Kdig\ArchaeologicalBundle\Entity\Preobject;
use Kdig\ArchaeologicalBundle\Form\PreobjectType;

/**
 * Preobject controller.
 *
 * @Route("/preobject")
 */
class PreobjectController extends Controller
{

    /**
     * Lists all Preobject entities.
     *
     * @Route("/", name="preobject")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('KdigArchaeologicalBundle:Preobject')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Preobject entity.
     *
     * @Route("/", name="preobject_create")
     * @Method("POST")
     * @Template("KdigArchaeologicalBundle:Preobject:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Preobject();
        $form = $this->createForm(new PreobjectType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('preobject_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Preobject entity.
     *
     * @Route("/new", name="preobject_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Preobject();
        $form   = $this->createForm(new PreobjectType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Preobject entity.
     *
     * @Route("/{id}", name="preobject_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KdigArchaeologicalBundle:Preobject')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Preobject entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Preobject entity.
     *
     * @Route("/{id}/edit", name="preobject_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KdigArchaeologicalBundle:Preobject')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Preobject entity.');
        }

        $editForm = $this->createForm(new PreobjectType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Preobject entity.
     *
     * @Route("/{id}", name="preobject_update")
     * @Method("PUT")
     * @Template("KdigArchaeologicalBundle:Preobject:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KdigArchaeologicalBundle:Preobject')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Preobject entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new PreobjectType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('preobject_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Preobject entity.
     *
     * @Route("/{id}", name="preobject_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('KdigArchaeologicalBundle:Preobject')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Preobject entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('preobject'));
    }

    /**
     * Creates a form to delete a Preobject entity by id.
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
