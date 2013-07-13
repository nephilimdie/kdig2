<?php

namespace Kdig\ArchaeologicalBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Kdig\ArchaeologicalBundle\Entity\Presample;
use Kdig\ArchaeologicalBundle\Form\PresampleType;

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
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('KdigArchaeologicalBundle:Presample')->findAll();

        return array(
            'entities' => $entities,
        );
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
        $entity  = new Presample();
        $form = $this->createForm(new PresampleType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

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
    public function newAction()
    {
        $entity = new Presample();
        $form   = $this->createForm(new PresampleType(), $entity);

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

        $entity = $em->getRepository('KdigArchaeologicalBundle:Presample')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Presample entity.');
        }

        $editForm = $this->createForm(new PresampleType(), $entity);
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

        $entity = $em->getRepository('KdigArchaeologicalBundle:Presample')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Presample entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new PresampleType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('presample_edit', array('id' => $id)));
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
        }

        return $this->redirect($this->generateUrl('presample'));
    }

    /**
     * Creates a form to delete a Presample entity by id.
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
