<?php

namespace Kdig\ArchaeologicalBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Kdig\ArchaeologicalBundle\Entity\Prepottery;
use Kdig\ArchaeologicalBundle\Form\PrepotteryType;

/**
 * Prepottery controller.
 *
 * @Route("/prepottery")
 */
class PrepotteryController extends Controller
{

    /**
     * Lists all Prepottery entities.
     *
     * @Route("/", name="prepottery")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('KdigArchaeologicalBundle:Prepottery')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Prepottery entity.
     *
     * @Route("/", name="prepottery_create")
     * @Method("POST")
     * @Template("KdigArchaeologicalBundle:Prepottery:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Prepottery();
        $form = $this->createForm(new PrepotteryType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('prepottery_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Prepottery entity.
     *
     * @Route("/new", name="prepottery_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Prepottery();
        $form   = $this->createForm(new PrepotteryType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Prepottery entity.
     *
     * @Route("/{id}", name="prepottery_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KdigArchaeologicalBundle:Prepottery')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Prepottery entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Prepottery entity.
     *
     * @Route("/{id}/edit", name="prepottery_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KdigArchaeologicalBundle:Prepottery')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Prepottery entity.');
        }

        $editForm = $this->createForm(new PrepotteryType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Prepottery entity.
     *
     * @Route("/{id}", name="prepottery_update")
     * @Method("PUT")
     * @Template("KdigArchaeologicalBundle:Prepottery:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KdigArchaeologicalBundle:Prepottery')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Prepottery entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new PrepotteryType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('prepottery_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Prepottery entity.
     *
     * @Route("/{id}", name="prepottery_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('KdigArchaeologicalBundle:Prepottery')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Prepottery entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('prepottery'));
    }

    /**
     * Creates a form to delete a Prepottery entity by id.
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
