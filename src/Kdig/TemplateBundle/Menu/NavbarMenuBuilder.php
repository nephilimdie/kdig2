<?php

namespace Kdig\TemplateBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContextInterface;

class NavbarMenuBuilder
{
    protected $securityContext;
    protected $selectedGroup = null;
    protected $selectedArea = null;
    protected $isLoggedIn = null;
    protected $isSuperAdmin = null;
    protected $role_pottery = null;
    protected $role_object = null;
    protected $role_sample = null;
    protected $role_archaeology = null;
    protected $role_media = null;
    protected $usr = null;
    
    private $factory;

    public function __construct(FactoryInterface $factory, SecurityContextInterface $securityContext)
    {
//        parent::__construct($factory);

        $this->factory = $factory;
        
        $this->securityContext = $securityContext;
        $this->isLoggedIn = $this->securityContext->isGranted('IS_AUTHENTICATED_FULLY');
        if($this->isLoggedIn) {
            if ($this->securityContext->isGranted('ROLE_SUPER_ADMIN'))
                $this->isSuperAdmin = $this->securityContext->isGranted('ROLE_SUPER_ADMIN');
            else {
                $this->selectedGroup = $securityContext->getToken()->getUser()->getSlectedgroup();
                if($this->selectedGroup) {
                    $this->selectedArea = $securityContext->getToken()->getUser()->getSlectedarea();
                    $this->role_pottery = $this->selectedGroup->hasRole('ROLE_POTTERY');
                    $this->role_object = $this->selectedGroup->hasRole('ROLE_OBJECT');
                    $this->role_sample = $this->selectedGroup->hasRole('ROLE_SAMPLE');
                    $this->role_archaeology = $this->selectedGroup->hasRole('ROLE_ARCHAEOLOGY');
                    $this->role_media = $this->selectedGroup->hasRole('ROLE_MEDIA');
                }
            }
            $this->usr = $securityContext->getToken()->getUser();
        }
    }

    public function createMainMenu(Request $request)
    {
//        $menu = $this->factory->createItem('root');
        
        $menu = $this->factory->createItem('root', array(
            'navbar' => true,
            'pull-right' => true,
        ));
        
        //$menu->setChildrenAttribute('class', 'nav');

        $layout = $menu->addChild('Home', array(
            'icon' => 'home',
            'route' => 'default_index',
        ));
        $layout = $menu->addChild('About', array(
            'icon' => 'sign',
            'route' => 'default_about',
        ));

//        $this->addDivider($menu, true);
        return $menu;
    }

    public function createUserSideDropdownMenu(Request $request)
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav pull-right');

        $dropdown = $menu->addChild('User', array(
            'dropdown' => true,
            'caret' => true,
        ));
        
//        $dropdown = $this->createDropdownMenuItem($menu, "User", true, array('caret' => true));
        if ($this->isLoggedIn) {
            $dropdown->setLabel($this->usr->getUsername());
            if ($this->isSuperAdmin) {
                $dropdown->addChild('Administration', array('route' => 'sonata_admin_dashboard'));
//                $this->addDivider($menu, true);
            }
            $dropdown->addChild('Logout', array('route' => 'fos_user_security_logout'));
        } else {
            $dropdown->addChild('login', array('route' => 'fos_user_security_login'));
        }
//        $this->addIcon($dropdown, array('icon' => 'user', 'inverted'=>false, 'append'=>false ));
        return $menu;
    }
    
    public function createSelectGroupMenu(Request $request)
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav pull-right');
        if ($this->isLoggedIn) {
            if($this->selectedGroup)
                
                $dropdown = $menu->addChild($this->selectedGroup->getName(), array(
                    'dropdown' => true,
                    'caret' => true,
                ));
        
//                $dropdown = $this->createDropdownMenuItem($menu, $this->selectedGroup->getName(), true, array('caret' => true));
            else
                $dropdown = $menu->addChild('none', array(
                    'dropdown' => true,
                    'caret' => true,
                ));
//                $dropdown = $this->createDropdownMenuItem($menu, 'none', true, array('caret' => true));
            foreach ($this->usr->getGroups() as $group)
                $dropdown->addChild($group->getName(), array('route' => 'user_change_group', 'routeParameters' => array('group_id' => $group->getId())));
        }
        return $menu;
    }
    
    public function createSelectAreaMenu(Request $request)
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav pull-right');
        if ($this->isLoggedIn) {
            if($this->selectedArea)
                $dropdown = $menu->addChild($this->selectedArea->getName(), array(
                    'dropdown' => true,
                    'caret' => true,
                ));
//                $dropdown = $this->createDropdownMenuItem($menu, $this->selectedArea->getName(), true, array('caret' => true));
            else
                $dropdown = $menu->addChild('none', array(
                    'dropdown' => true,
                    'caret' => true,
                ));
//                $dropdown = $this->createDropdownMenuItem($menu, 'none', true, array('caret' => true));
            foreach ($this->usr->getSlectedgroup()->getAreas() as $area)
                $dropdown->addChild($area->getName(), array('route' => 'user_change_area', 'routeParameters' => array('area_id' => $area->getId())));
        }
        return $menu;
    }

    public function createArchaeologicalMenu(Request $request)
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav nav-pills nav-stacked');
        if ($this->role_archaeology) { 
            $menu->addChild('SU', array('route' => 'us_home'));
            $menu->addChild('Bucket', array('route' => 'bucket_home'));
            $menu->addChild('Object', array('route' => 'preobject_home'));
            $menu->addChild('Pottery', array('route' => 'prepottery_home'));
            $menu->addChild('Sample', array('route' => 'presample_home'));
        
        } elseif ($this->role_pottery) {
            $menu->addChild('SU', array('route' => 'us_home'));
            $menu->addChild('Bucket', array('route' => 'bucket_home'));
            $menu->addChild('Pottery', array('route' => 'pottery_home'));
            
        } elseif ($this->role_object) {
            $menu->addChild('SU', array('route' => 'us_home'));
            $menu->addChild('Bucket', array('route' => 'bucket_home'));
            $menu->addChild('Object', array('route' => 'object_home'));
            
        } elseif ($this->role_sample) {
            $menu->addChild('SU', array('route' => 'us_home'));
            $menu->addChild('Bucket', array('route' => 'bucket_home'));
            $menu->addChild('Sample', array('route' => 'sample_home'));
        }

        if ($this->role_media) {
            $menu->addChild('Media', array('route' => 'media_index'));
            $menu->addChild('Photo List', array('route' => 'photolist_add'));
        }
        return $menu;
    }

}