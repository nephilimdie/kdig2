<?php

namespace Kdig\ArchaeologicalBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Kdig\ArchaeologicalBundle\Entity\Us;
use Kdig\ArchaeologicalBundle\Form\UsType;

/**
 * Us controller.
 *
 * @Route("/us")
 */
class UsController extends Controller
{

    /**
     * Lists all Us entities.
     *
     * @Route("/", name="us")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('KdigArchaeologicalBundle:Us')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Us entity.
     *
     * @Route("/", name="us_create")
     * @Method("POST")
     * @Template("KdigArchaeologicalBundle:Us:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Us();
        $form = $this->createForm(new UsType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('us_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Us entity.
     *
     * @Route("/new", name="us_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Us();
        $form   = $this->createForm(new UsType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Us entity.
     *
     * @Route("/{id}", name="us_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KdigArchaeologicalBundle:Us')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Us entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Us entity.
     *
     * @Route("/{id}/edit", name="us_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KdigArchaeologicalBundle:Us')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Us entity.');
        }

        $editForm = $this->createForm(new UsType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Us entity.
     *
     * @Route("/{id}", name="us_update")
     * @Method("PUT")
     * @Template("KdigArchaeologicalBundle:Us:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KdigArchaeologicalBundle:Us')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Us entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new UsType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('us_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Us entity.
     *
     * @Route("/{id}", name="us_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('KdigArchaeologicalBundle:Us')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Us entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('us'));
    }

    /**
     * Creates a form to delete a Us entity by id.
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
