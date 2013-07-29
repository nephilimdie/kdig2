<?php

namespace Kdig\OrientBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Mopa\Bundle\BootstrapBundle\Navbar\AbstractNavbarMenuBuilder;

class OrientMenuBuilder extends AbstractNavbarMenuBuilder
{
    protected $securityContext;
    protected $isLoggedIn;

    public function __construct(FactoryInterface $factory, SecurityContextInterface $securityContext)
    {
        parent::__construct($factory);

        $this->securityContext = $securityContext;
        $this->isLoggedIn = $this->securityContext->isGranted('IS_AUTHENTICATED_FULLY');
        $this->isSuperAdmin = $this->securityContext->isGranted('ROLE_SUPER_ADMIN');
        $this->role_pottery = $this->securityContext->isGranted('ROLE_POTTERY');
        $this->role_object = $this->securityContext->isGranted('ROLE_OBJECT');
        $this->role_sample = $this->securityContext->isGranted('ROLE_SAMPLE');
        $this->role_archaeology = $this->securityContext->isGranted('ROLE_ARCHAEOLOGY');
        $this->role_media = $this->securityContext->isGranted('ROLE_MEDIA');
        $this->usr = $securityContext->getToken()->getUser();
    }

    public function createPotteryShowMenu(Request $request)
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav show-menu');
        $id = $request->get('id');
//        die(var_dump($request));
        $list = $menu->addChild('list', array('route' => 'pottery'));
        $this->addIcon($list, array('icon' => 'th-list', 'inverted'=>false, 'append'=>false ));
        if($this->role_pottery) {
            $edit = $menu->addChild('edit', array('route' => 'pottery_edit', 'routeParameters' => array('id' => $id)));
            $this->addIcon($edit, array('icon' => 'pencil', 'inverted'=>false, 'append'=>false ));
            $this->addDivider($menu, true);
            $delete = $menu->addChild('delete', array('route' => 'pottery_delete', 'class'=> 'btn btn-danger', 'routeParameters' => array('id' => $id)));
            $this->addIcon($delete, array('icon' => 'remove', 'inverted'=>false, 'append'=>false ));
            $delete->setAttributes(array('class'=>'btn btn-danger'));
        }
        $this->addDivider($menu, true);
        $export = $this->createDropdownMenuItem($menu, "export", true, array('caret' => true));
        $pdf = $export->addChild('PDF', array('route' => 'pottery'));
        $zip = $export->addChild('zip', array('route' => 'pottery'));
        return $menu;
    }
    public function createObjectShowMenu(Request $request)
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav show-menu');
        $id = $request->get('id');
        $list = $menu->addChild('list', array('route' => 'object'));
        $this->addIcon($list, array('icon' => 'th-list', 'inverted'=>false, 'append'=>false ));
        if($this->role_object) {
            $edit = $menu->addChild('edit', array('route' => 'object_edit', 'routeParameters' => array('id' => $id)));
            $this->addIcon($edit, array('icon' => 'pencil', 'inverted'=>false, 'append'=>false ));
            $this->addDivider($menu, true);
            $delete = $menu->addChild('delete', array('route' => 'object_delete', 'routeParameters' => array('id' => $id)));
            $this->addIcon($delete, array('icon' => 'remove', 'inverted'=>false, 'append'=>false ));
        }
        $this->addDivider($menu, true);
        $export = $this->createDropdownMenuItem($menu, "export", true, array('caret' => true));
        $pdf = $export->addChild('PDF', array('route' => 'object'));
        $zip = $export->addChild('zip', array('route' => 'object'));
        return $menu;
    }
    public function createSampleShowMenu(Request $request)
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav show-menu');
        $id = $request->get('id');
        $list = $menu->addChild('list', array('route' => 'sample'));
        $this->addIcon($list, array('icon' => 'th-list', 'inverted'=>false, 'append'=>false ));
        if($this->role_sample) {
            $edit = $menu->addChild('edit', array('route' => 'sample_edit', 'routeParameters' => array('id' => $id)));
            $this->addIcon($edit, array('icon' => 'pencil', 'inverted'=>false, 'append'=>false ));
            $this->addDivider($menu, true);
            $delete = $menu->addChild('delete', array('route' => 'sample_delete', 'routeParameters' => array('id' => $id)));
            $this->addIcon($delete, array('icon' => 'remove', 'inverted'=>false, 'append'=>false ));
        }
        $this->addDivider($menu, true);
        $export = $this->createDropdownMenuItem($menu, "export", true, array('caret' => true));
        $pdf = $export->addChild('PDF', array('route' => 'sample'));
        $zip = $export->addChild('zip', array('route' => 'sample'));
        return $menu;
    }
    
    public function createVocsPotteryMenu(Request $request) 
    {
        $menu = $this->factory->createItem('root', array('childrenAttributes' => array('class' => 'btn')));
        $menu->setChildrenAttribute('class', 'row-fluid');
        
        $base = $menu->addChild('Base', array('route' => 'pottery'));
        $base->setAttributes(array('class'=>'btn'));
        $this->addIcon($base, array('icon' => 'file', 'inverted'=>false, 'append'=>false ));
        
        $class = $menu->addChild('Class', array('route' => 'pottery'));
        $class->setAttributes(array('class'=>'btn'));
        $this->addIcon($class, array('icon' => 'file', 'inverted'=>false, 'append'=>false ));
        
        $menu->addChild('Color', array('route' => 'pottery'));
        $class->setAttributes(array('class'=>'btn'));
        $this->addIcon($class, array('icon' => 'file', 'inverted'=>false, 'append'=>false ));
        
        $menu->addChild('Decoration Option', array('route' => 'pottery'));
        $menu->addChild('Firing', array('route' => 'pottery'));
        $menu->addChild('Handle', array('route' => 'pottery'));
        $menu->addChild('Handle Position', array('route' => 'pottery'));
        $menu->addChild('Inclusion', array('route' => 'pottery'));
        $menu->addChild('Inclusion Frequency', array('route' => 'pottery'));
        $menu->addChild('Inclusion Size', array('route' => 'pottery'));
        $menu->addChild('Decoration Option', array('route' => 'pottery'));
        $menu->addChild('Wall', array('route' => 'pottery'));
        $menu->addChild('Upper Wall', array('route' => 'pottery'));
        $menu->addChild('Lower Wall', array('route' => 'pottery'));
        $menu->addChild('Neck', array('route' => 'pottery'));
        $menu->addChild('Preservation', array('route' => 'pottery'));
        $menu->addChild('Rim', array('route' => 'pottery'));
        $menu->addChild('Shape', array('route' => 'pottery'));
        $menu->addChild('Spout', array('route' => 'pottery'));
        $menu->addChild('Spout Position', array('route' => 'pottery'));
        $menu->addChild('Surface Treatment Option', array('route' => 'pottery'));
        $menu->addChild('Technique', array('route' => 'pottery'));
        
        $menu->setLabelAttributes(array('class'=> 'sapn1'));
        $menu->setAttributes(array('class'=> 'sapn1'));
        
        return $menu;
    }

}