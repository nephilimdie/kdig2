<?php

namespace Kdig\OrientBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\View\TwitterBootstrapView;

use Kdig\OrientBundle\Entity\Photolist;
use Kdig\OrientBundle\Form\PhotolistType;
use Kdig\OrientBundle\Form\PhotolistFilterType;

use APY\DataGridBundle\Grid\Source\Entity;
use APY\DataGridBundle\Grid\Action\RowAction;
use APY\DataGridBundle\Grid\Action\MassAction;
use APY\DataGridBundle\Grid\Action\DeleteMassAction;
use APY\DataGridBundle\Grid\Column\ActionsColumn;
use APY\DataGridBundle\Grid\Export\PHPExcel2007Export;

use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * Photolist controller.
 *
 * @Route("/photolist")
 */
class PhotolistController extends Controller
{
    /**
     * Lists all Photolist entities.
     *
     * @Route("/", name="photolist")
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
        $filterForm = $this->createForm(new PhotolistFilterType());
        $em = $this->getDoctrine()->getManager();
        $queryBuilder = $em->getRepository('KdigOrientBundle:Photolist')->createQueryBuilder('e');

        // Reset filter
        if ($request->get('filter_action') == 'reset') {
            $session->remove('PhotolistControllerFilter');
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
                $session->set('PhotolistControllerFilter', $filterData);
            }
        } else {
            // Get filter from session
            if ($session->has('PhotolistControllerFilter')) {
                $filterData = $session->get('PhotolistControllerFilter');
                $filterForm = $this->createForm(new PhotolistFilterType(), $filterData);
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
            return $me->generateUrl('photolist', array('page' => $page));
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
     * Creates a new Photolist entity.
     *
     * @Route("/", name="photolist_create")
     * @Method("POST")
     * @Template("KdigOrientBundle:Photolist:new.html.twig")
     * @Secure(roles="ROLE_MEDIA , ROLE_ADMIN")
     */
    public function createAction(Request $request)
    {
        $entity  = new Photolist();
        $form = $this->createForm(new PhotolistType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.create.success');

            return $this->redirect($this->generateUrl('photolist_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Photolist entity.
     *
     * @Route("/new", name="photolist_new")
     * @Template()
     * @Secure(roles="ROLE_MEDIA , ROLE_ADMIN")
     */
    public function newAction()
    {
        $entity = new Photolist();
        $form   = $this->createForm(new PhotolistType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Photolist entity.
     *
     * @Route("/{id}", name="photolist_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KdigOrientBundle:Photolist')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Photolist entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Photolist entity.
     *
     * @Route("/{id}/edit", name="photolist_edit")
     * @Method("GET")
     * @Template()
     * @Secure(roles="ROLE_MEDIA , ROLE_ADMIN")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KdigOrientBundle:Photolist')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Photolist entity.');
        }

        $editForm = $this->createForm(new PhotolistType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Photolist entity.
     *
     * @Route("/{id}", name="photolist_update")
     * @Method("PUT")
     * @Template("KdigOrientBundle:Photolist:edit.html.twig")
     * @Secure(roles="ROLE_MEDIA , ROLE_ADMIN")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KdigOrientBundle:Photolist')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Photolist entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new PhotolistType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.update.success');

            return $this->redirect($this->generateUrl('photolist_edit', array('id' => $id)));
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
     * Deletes a Photolist entity.
     *
     * @Route("/{id}", name="photolist_delete")
     * @Method("DELETE")
     * @Secure(roles="ROLE_MEDIA , ROLE_ADMIN")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('KdigOrientBundle:Photolist')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Photolist entity.');
            }

            $em->remove($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.delete.success');
        } else {
            $this->get('session')->getFlashBag()->add('error', 'flash.delete.error');
        }

        return $this->redirect($this->generateUrl('photolist'));
    }

    /**
     * Creates a form to delete a Photolist entity by id.
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
     * @Route("/add/", name="photolist_add")
     * @Method("GET")
     * @Template()
     * @Secure(roles="ROLE_MEDIA , ROLE_ADMIN")
     */
    public function addAction()
    {
        return array();
    }
    
    /**
     * @Route("/merge/", name="photolist_merge")
     * @Method("GET")
     * @Template()
     * @Secure(roles="ROLE_MEDIA , ROLE_ADMIN")
     */
    public function mergephotoAction(Request $request) {
        // get list isMerged false
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('KdigOrientBundle:Photolist')->findBy(array('isMerged'=>true));
        //  get photofrom
        $photoFrom = $entity->getFromnumber();
        //  get phototo
        $photoTo = $entity->getTonumber();
        // get vocmachine
        $machine = $entity->getVocmachine()->getName();
        //  $areas = get Entities Area
        $areas = $entity->getArea();
        //  $uss = get Entities US
        $uss = $entity->getUs();
        //  $objs = get Entities Obj
        $objs = $entity->getObject();
        //  $pots = get Entities Pottery
        $pots = $entity->getPottery();
        //  $sams = get Entities Sample
        $sams = $entity->getSample();
        // 
        $photonotexist = array();
        // for from photoFrom to photoTo
        for ($i=$photoFrom; $i<=$photoTo; $i++) {
            //make photoname --- check number of character in name, maybe 4 numbers. eg 0291
            $namePhoto = $machine.$i;
            //      $photo = find photo in Media
            $photo  = $em->getRepository('KdigMediaBundle:Media')->findOneBy(array('name'=>$namePhoto));
        //      if photo not exist in media, so in array -> tell to user
            if(!$photo)
                $photonotexist[] = $namePhoto; //so "queste foto non sono state ancora caricate" dunque crea nuova lista photononcaricate
        //      if photo exist in media
            else {
                foreach ($areas as $area) {
        //                  if photo isInArray() of element
                    $area->setMedia($photo);
                    $area->save();
                }
        //              foreach ($uss ad $us)
                foreach ($uss as $us) {
        //                  if photo isInArray() of element
                    $us->setMedia($photo);
                    $us->save();
                }
                foreach ($objs as $obj) {
        //                  if photo isInArray() of element
                    $obj->setMedia($photo);
                    $obj->save();
                }
                foreach ($pots as $pot){
        //                  if photo isInArray() of element
                    $pot->setMedia($photo);
                    $pot->save();
                }
                foreach ($sams as $sam) {
        //                  if photo isInArray() of element
                    $sam->setMedia($photo);
                    $sam->save();
                }
            } //end else
        }  //end for
    }
}
