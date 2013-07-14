<?php
// src/Tutorial/BlogBundle/Admin/PostAdmin.php
namespace Kdig\ArchaeologicalBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

use Knp\Menu\ItemInterface as MenuItemInterface;

use Kdig\ArchaeologicalBundle\Entity\Site;

class AreaAdmin extends Admin
{
    /**
     * @param \Sonata\AdminBundle\Show\ShowMapper $showMapper
     *
     * @return void
     */
    protected function configureShowField(ShowMapper $showMapper)
    {
        $showMapper
            ->add('name')
            ->add('groups')
            ->add('fromrefbucket')
            ->add('torefbucket')
            ->add('fromrefus')
            ->add('torefus')
            ->add('remarks')
            ->add('type')
            ->add('isActive')
            ->add('isPublic')
            ->add('created')
        ;
    }

    /**
     * @param \Sonata\AdminBundle\Form\FormMapper $formMapper
     *
     * @return void
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General')
                ->add('name')
                ->add('groups', 'sonata_type_model', array('required' => true))
                ->add('fromrefbucket')
                ->add('torefbucket')
                ->add('fromrefus')
                ->add('torefus')
                ->add('remarks')
                ->add('type', 'sonata_type_model', array('required' => true))
                ->add('isActive')
                ->add('isPublic')
            ->end()
        ;
    }

    /**
     * @param \Sonata\AdminBundle\Datagrid\ListMapper $listMapper
     *
     * @return void
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
            ->add('groups')
            ->add('fromrefbucket')
            ->add('torefbucket')
            ->add('fromrefus')
            ->add('torefus')
            ->add('remarks')
            ->add('type')
            ->add('isActive')
            ->add('isPublic')
            ->add('created')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'view' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }

    /**
     * @param \Sonata\AdminBundle\Datagrid\DatagridMapper $datagridMapper
     *
     * @return void
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('groups')
            ->add('fromrefbucket')
            ->add('torefbucket')
            ->add('fromrefus')
            ->add('torefus')
            ->add('remarks')
            ->add('type')
            ->add('isActive')
            ->add('isPublic')
            ->add('created')
        ;
    }
}


