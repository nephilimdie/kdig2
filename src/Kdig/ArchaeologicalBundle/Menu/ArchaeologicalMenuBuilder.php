<?php

namespace Kdig\ArchaeologicalBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContextInterface;

class ArchaeologicalMenuBuilder 
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
    
    public function createUsShowMenu(Request $request) {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav show-menu');
        $id = $request->get('id');
//        die(var_dump($request));
        $list = $menu->addChild('list', array('route' => 'us'));
        $this->addIcon($list, array('icon' => 'th-list', 'inverted'=>false, 'append'=>false ));
        $edit = $menu->addChild('edit', array('route' => 'us_edit', 'routeParameters' => array('id' => $id)));
        $this->addIcon($edit, array('icon' => 'pencil', 'inverted'=>false, 'append'=>false ));
        $this->addDivider($menu, true);
        $delete = $menu->addChild('delete', array('route' => 'us_delete', 'routeParameters' => array('id' => $id, 'class'=> 'btn btn-danger')));
        $this->addIcon($delete, array('icon' => 'remove', 'inverted'=>false, 'append'=>false ));
        $this->addDivider($menu, true);
        $export = $this->createDropdownMenuItem($menu, "export", true, array('caret' => true));
        $pdf = $export->addChild('PDF', array('route' => 'us'));
        $zip = $export->addChild('zip', array('route' => 'us'));
        
        return $menu;
    }
}