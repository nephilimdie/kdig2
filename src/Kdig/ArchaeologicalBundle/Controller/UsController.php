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

use Kdig\ArchaeologicalBundle\Entity\Us;
use Kdig\ArchaeologicalBundle\Form\UsType;
use Kdig\ArchaeologicalBundle\Form\UsFilterType;

use APY\DataGridBundle\Grid\Source\Entity;
use APY\DataGridBundle\Grid\Action\RowAction;
use APY\DataGridBundle\Grid\Column\ActionsColumn;
use APY\DataGridBundle\Grid\Export\PHPExcel2007Export;
use APY\BreadcrumbTrailBundle\Annotation\Breadcrumb;

use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * Us controller.
 *
 * @Route("/us")
 * @Breadcrumb("Stratigraphics Unit", route="us")
 */
class UsController extends Controller
{
    /**
     * Lists all Us entities in grid
     *
     * @Route("/", name="us")
     * @Breadcrumb("Table", route="us")
     * @Method("GET")
     * @Template("KdigTemplateBundle:Default:Grid/grid.html.twig")
     * @Secure(roles="ROLE_ARCHAEOLOGY, ROLE_ADMIN, ROLE_POTTERY, ROLE_SAMPLE, ROLE_OBJECT")
     */
    public function myGridAction()
    {
        $source = new Entity('KdigArchaeologicalBundle:Us');
        $grid = $this->get('grid');
        $grid->setSource($source);
        // Configuration of the grid
        // 
        // Create an Actions Column
        $actionsColumn = new ActionsColumn('info_column_1', 'Actions');
        $actionsColumn->setSeparator("<br />");
        $grid->addColumn($actionsColumn, 1);

        // Attach a rowAction to the Actions Column
        $showAction = new RowAction('Show', 'us_show', null, null, array('class'=>'ajax'));
        $showAction->setColumn('info_column');
        $grid->addRowAction($showAction);
//        // OR add a second row action directly to a new action column
//        $rowAction2 = new RowAction('Edit', 'pottery_edit');
//        $actionsColumn2 = new ActionsColumn($column, $title, array(rowAction2), $separator);
//        $grid->addColumn($actionsColumn2, $position2);
        $fileName = 'us-'.date("d-m-Y");
        $export = new PHPExcel2007Export('Excel Us 2007 Export',$fileName, array(), 'UTF-8', 'ROLE_USER');

        $export->objPHPExcel->getProperties()->setCreator("KdigProject");
        $export->objPHPExcel->getProperties()->setLastModifiedBy("KdigProject");
        $export->objPHPExcel->getProperties()->setTitle("KdigProject Document");
        $export->objPHPExcel->getProperties()->setSubject("KdigProject Document");
        $export->objPHPExcel->getProperties()->setDescription("KdigProject");
        $export->objPHPExcel->getProperties()->setKeywords("KdigProject");
        $export->objPHPExcel->getProperties()->setCategory("KdigProject");

        $grid->addExport($export);

        // Manage the grid redirection, exports and the response of the controller
        return $grid->getGridResponse('KdigTemplateBundle:Default:Grid\grid.html.twig');
    }
    
    /**
     * Lists all Us entities.
     *
     * @Route("/home/", name="us_home")
     * @Breadcrumb("SU Home", route="us_home")
     * @Secure(roles="ROLE_ARCHAEOLOGY, ROLE_ADMIN, ROLE_POTTERY, ROLE_SAMPLE, ROLE_OBJECT")
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
        $filterForm = $this->createForm(new UsFilterType());
        $em = $this->getDoctrine()->getManager();
        $queryBuilder = $em->getRepository('KdigArchaeologicalBundle:Us')->createQueryBuilder('e');

        // Reset filter
        if ($request->get('filter_action') == 'reset') {
            $session->remove('UsControllerFilter');
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
                $session->set('UsControllerFilter', $filterData);
            }
        } else {
            // Get filter from session
            if ($session->has('UsControllerFilter')) {
                $filterData = $session->get('UsControllerFilter');
                $filterForm = $this->createForm(new UsFilterType(), $filterData);
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
            return $me->generateUrl('us', array('page' => $page));
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

    private function getArea() {
        
        $user = $this->get('security.context')->getToken()->getUser();
        $group = $user->getSlectedgroup();
        foreach ($group->getAreas() as $area)
            $areas[]=$area->getId(); 
        return $areas;
    }
    
    /**
     * Creates a new Us entity.
     *
     * @Route("/", name="us_create")
     * @Method("POST")
     * @Template("KdigArchaeologicalBundle:Us:new.html.twig")
     * @Secure(roles="ROLE_ARCHAEOLOGY, ROLE_ADMIN, ROLE_POTTERY, ROLE_SAMPLE, ROLE_OBJECT")
     */
    public function createAction(Request $request)
    {
        $areas = $this->getArea();
        
        $entity  = new Us();
        $form = $this->createForm(new UsType($areas, null), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.create.success');

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
     * @Breadcrumb("New SU", route="us_new")
     * @Secure(roles="ROLE_ARCHAEOLOGY, ROLE_ADMIN, ROLE_POTTERY, ROLE_SAMPLE, ROLE_OBJECT")
     * @Template()
     */
    public function newAction()
    {
        $areas = $this->getArea();
        $entity = new Us();
        $form   = $this->createForm(new UsType($areas, null), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Us entity.
     *
     * @Route("/{id}", name="us_show")
     * @Breadcrumb("Show SU",  route={"name"="us_show", "parameters"={"id"}})
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
     * @Breadcrumb("Edit SU",  route={"name"="us_edit", "parameters"={"id"}})
     * @Secure(roles="ROLE_ARCHAEOLOGY, ROLE_ADMIN, ROLE_POTTERY, ROLE_SAMPLE, ROLE_OBJECT")
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

        $areas = $this->getArea();
        
        $editForm = $this->createForm(new UsType($areas, null), $entity);
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
     * @Secure(roles="ROLE_ARCHAEOLOGY, ROLE_ADMIN, ROLE_POTTERY, ROLE_SAMPLE, ROLE_OBJECT")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KdigArchaeologicalBundle:Us')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Us entity.');
        }
        $areas = $this->getArea();

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new UsType($areas, null), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.update.success');

            return $this->redirect($this->generateUrl('us_show', array('id' => $id)));
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
     * Deletes a Us entity.
     *
     * @Route("/{id}/delete", name="us_delete")
     *
     * @Secure(roles="ROLE_ARCHAEOLOGY, ROLE_ADMIN, ROLE_POTTERY, ROLE_SAMPLE, ROLE_OBJECT")
     */
    public function deleteAction(Request $request, $id)
    {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('KdigArchaeologicalBundle:Us')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Us entity.');
            }

            $em->remove($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.delete.success');
        return $this->redirect($this->generateUrl('us'));
    }

    /**
     * Creates a form to delete a Us entity by id.
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
     * Get a default text for Us from selected us.
     *
     * @Route("/{id_site}/{id_area}/getdefaulttext", name="kdig_us_defaulttext", options={"expose"=true})
     * @Method("post")
     */
    public function getdefaulttextaction(Request $request) 
    {
        $user = $this->get('security.context')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $id_site = $request->get('id_site');
        $id_area = $request->get('id_area');
        $site = $em->getRepository('KdigArchaeologicalBundle:Site')->findOneById($id_site);
        $sigla = $site->getSigla();

        $area = $em->getRepository('KdigArchaeologicalBundle:Area')->findOneById($id_area);
        if (!$area) {
            throw $this->createNotFoundException('Unable to find Area entity.');
        }
        $stringa = $em->getRepository('KdigArchaeologicalBundle:Us')->freeName($sigla, $area);
        
        return new Response($stringa);
    }
    
    /** 
     * Get a default text for Us from selected us.
     *
     * @Route("/{name}/checkname", name="kdig_us_checkname", options={"expose"=true})
     * @Method("get")
     */
    public function checkname($name)
    { 
        $em = $this->getDoctrine()->getEntityManager();
        $response = $em->getRepository('KdigArchaeologicalBundle:Us')->isUnusedName($name);
        if($response)
            $stringa = '<label style="button green">OK</label>';
        else 
            $stringa = '<label style="button red">the name exist <a href="'.$this->generateUrl('kdig_us_show', array('id' => $response->getId())).'">'.$response->getName().'</a></label>';
        return new Response($stringa);
    }
}
