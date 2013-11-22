<?php

namespace Kdig\OrientBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContextInterface;

class OrientMenuBuilder 
{
    protected $securityContext;
    protected $isLoggedIn;

    public function __construct(FactoryInterface $factory, SecurityContextInterface $securityContext) {
        //parent::__construct($factory);

        $this->factory = $factory;
        
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
    
    public function createShowElementMenu (Request $request) {
        
        $menu = $this->factory->createItem('root', array(
            'pull-right' => true,
            'pills' => true
        ));
//        $menu->setChildrenAttributes(array('class' =>'nav show-menu'));
        //show
        $name =split('_', $request->get('_route'));
        $controller = $name[0];
        $show = $controller."_show";
        $home = $controller."_home";
        $edit = $controller."_edit";
        $new = $controller."_new";
        $delete = $controller."_delete";
        $list = $controller;
        $export_pdf = "";
        $export_zip = "";
        $id = $request->get('id', null);
//        die(var_dump($request));

        $home_menu = $menu->addChild('list', array('route' => $home, 'icon' => 'list'));
        $list_menu = $menu->addChild('list', array('route' => $list, 'icon' => 'list'));
        $new_menu = $menu->addChild('new', array('route' => $new, 'icon' => 'plus-sign'));
        
        $dropdown = $menu->addChild('Actions', array(
            'dropdown' => true,
            'caret' => true,
            'icon' => 'cog'
        ));
        if($id) {
            $edit_menu = $dropdown->addChild('edit', array('route' => $edit, 'routeParameters' => array('id' => $id), 'icon' => 'pencil'));
            $delete_menu = $dropdown->addChild('delete', array(
                'route' => $delete, 
                'routeParameters' => array('id' => $id), 
                'icon' => 'remove-circle'
            ));
        }
        if($this->role_pottery) {
        } elseif($this->role_object) {
            
        } elseif($this->role_sample) {
            
        }  elseif($this->role_archaeology) {
            
        } 
        if($this->role_media) {
            
        }

        return $menu;
    }
    public function createLeftMenu(Request $request) {
        $menu = $this->factory->createItem('root', array(
            'stacked' => true,
            'pull-left' => true,
            'pills' => true
        ));
//        $menu->setChildrenAttributes(array('class' =>'nav show-menu'));
        //show
        $name =split('_', $request->get('_route'));
        $controller = $name[0];
        $show = $controller."_show";
        $home = $controller."_home";
        $edit = $controller."_edit";
        $new = $controller."_new";
        $delete = $controller."_delete";
        $list = $controller;
        $export_pdf = "";
        $export_zip = "";
        $id = $request->get('id', null);
//        die(var_dump($request));

        $home_menu = $menu->addChild('list', array('route' => $home));
        $list_menu = $menu->addChild('list', array('route' => $list));
        $new_menu = $menu->addChild('new', array('route' => $new));
        if($this->role_pottery) {
        } elseif($this->role_object) {
            
        } elseif($this->role_sample) {
            
        }  elseif($this->role_archaeology) {
            
        } 
        if($this->role_media) {
            
        }

        //new
        //edit
        //grid
        //home
        return $menu;
    }
    
    public function createPotteryShowMenu(Request $request) {
        $menu = $this->factory->createItem('root', array(
            'stacked' => true,
            'pills' => true
        ));
//        $menu->setChildrenAttribute('class', 'nav show-menu');
        $id = $request->get('id');
        die(var_dump($request));
        $list = $menu->addChild('list', array('route' => 'pottery'));
//        $this->addIcon($list, array('icon' => 'th-list', 'inverted'=>false, 'append'=>false ));
        if($this->role_pottery) {
            $edit = $menu->addChild('edit', array('route' => 'pottery_edit', 'routeParameters' => array('id' => $id)));
//            $this->addIcon($edit, array('icon' => 'pencil', 'inverted'=>false, 'append'=>false ));
//            $this->addDivider($menu, true);
            $delete = $menu->addChild('delete', array('route' => 'pottery_delete', 'class'=> 'btn btn-danger', 'routeParameters' => array('id' => $id)));
//            $this->addIcon($delete, array('icon' => 'remove', 'inverted'=>false, 'append'=>false ));
            $delete->setAttributes(array('class'=>'btn btn-danger'));
        }
//        $this->addDivider($menu, true);
        
        $export = $menu->addChild('export', array(
            'dropdown' => true,
            'caret' => true,
        ));
//        $export = $this->createDropdownMenuItem($menu, "export", true, array('caret' => true));
        $pdf = $export->addChild('PDF', array('route' => 'pottery'));
        $zip = $export->addChild('zip', array('route' => 'pottery'));
        return $menu;
    }
    
    public function createObjectShowMenu(Request $request) {
        $menu = $this->factory->createItem('root', array(
            'stacked' => true,
            'pills' => true
        ));
//        $menu->setChildrenAttribute('class', 'nav show-menu');
        $id = $request->get('id');
        $list = $menu->addChild('list', array('route' => 'object'));
//        $this->addIcon($list, array('icon' => 'th-list', 'inverted'=>false, 'append'=>false ));
        if($this->role_object) {
            $edit = $menu->addChild('edit', array('route' => 'object_edit', 'routeParameters' => array('id' => $id)));
//            $this->addIcon($edit, array('icon' => 'pencil', 'inverted'=>false, 'append'=>false ));
//            $this->addDivider($menu, true);
            $delete = $menu->addChild('delete', array('route' => 'object_delete', 'routeParameters' => array('id' => $id)));
//            $this->addIcon($delete, array('icon' => 'remove', 'inverted'=>false, 'append'=>false ));
        }
//        $this->addDivider($menu, true);
        
        $export = $menu->addChild('export', array(
            'dropdown' => true,
            'caret' => true,
        ));
//        $export = $this->createDropdownMenuItem($menu, "export", true, array('caret' => true));
        $pdf = $export->addChild('PDF', array('route' => 'object'));
        $zip = $export->addChild('zip', array('route' => 'object'));
        return $menu;
    }
    
    public function createSampleShowMenu(Request $request) {
        $menu = $this->factory->createItem('root', array(
            'stacked' => true,
            'pull-right' => true,
            'pills' => true
        ));
//        $menu->setChildrenAttribute('class', 'nav show-menu');
        $id = $request->get('id');
        $list = $menu->addChild('list', array('route' => 'sample'));
//        $this->addIcon($list, array('icon' => 'th-list', 'inverted'=>false, 'append'=>false ));
        if($this->role_sample) {
            $edit = $menu->addChild('edit', array('route' => 'sample_edit', 'routeParameters' => array('id' => $id)));
//            $this->addIcon($edit, array('icon' => 'pencil', 'inverted'=>false, 'append'=>false ));
            $this->addDivider($menu, true);
            $delete = $menu->addChild('delete', array('route' => 'sample_delete', 'routeParameters' => array('id' => $id)));
//            $this->addIcon($delete, array('icon' => 'remove', 'inverted'=>false, 'append'=>false ));
        }
//        $this->addDivider($menu, true);
        $export = $menu->addChild('export', array(
            'dropdown' => true,
            'caret' => true,
        ));
//        $export = $this->createDropdownMenuItem($menu, "export", true, array('caret' => true));
        $pdf = $export->addChild('PDF', array('route' => 'sample'));
        $zip = $export->addChild('zip', array('route' => 'sample'));
        return $menu;
    }
    
    private function createVocsObject($menu)  {
        $base = $menu->addChild('Class', array('route' => 'pottery'));
        $base->setAttributes(array('class'=>''));
        $base->setLinkAttributes(array('class'=>''));
//        $this->addIcon($base, array('icon' => 'file', 'inverted'=>false, 'append'=>false ));
        $tec = $menu->addChild('Date', array('route' => 'pottery'));
        $tec->setAttributes(array('class'=>''));
        $tec->setLinkAttributes(array('class'=>''));
//        $this->addIcon($tec, array('icon' => 'file', 'inverted'=>false, 'append'=>false ));
        $base = $menu->addChild('Decoration', array('route' => 'pottery'));
        $base->setAttributes(array('class'=>''));
        $base->setLinkAttributes(array('class'=>''));
//        $this->addIcon($base, array('icon' => 'file', 'inverted'=>false, 'append'=>false ));
        $tec = $menu->addChild('Material', array('route' => 'pottery'));
        $tec->setAttributes(array('class'=>''));
        $tec->setLinkAttributes(array('class'=>''));
//        $this->addIcon($tec, array('icon' => 'file', 'inverted'=>false, 'append'=>false ));
        $base = $menu->addChild('Preservation', array('route' => 'pottery'));
        $base->setAttributes(array('class'=>''));
        $base->setLinkAttributes(array('class'=>''));
//        $this->addIcon($base, array('icon' => 'file', 'inverted'=>false, 'append'=>false ));
        $tec = $menu->addChild('Technique', array('route' => 'pottery'));
        $tec->setAttributes(array('class'=>''));
        $tec->setLinkAttributes(array('class'=>''));
//        $this->addIcon($tec, array('icon' => 'file', 'inverted'=>false, 'append'=>false ));
        $base = $menu->addChild('Type', array('route' => 'pottery'));
        $base->setAttributes(array('class'=>''));
        $base->setLinkAttributes(array('class'=>''));
//        $this->addIcon($base, array('icon' => 'file', 'inverted'=>false, 'append'=>false ));
        
        return $menu;
    }
    
    private function createVocsPottery($menu) {
        
        $base = $menu->addChild('Base', array('route' => 'pottery'));
        $base->setAttributes(array('class'=>''));
        $base->setLinkAttributes(array('class'=>''));
//        $this->addIcon($base, array('icon' => 'file', 'inverted'=>false, 'append'=>false ));
        
        $class = $menu->addChild('Class', array('route' => 'pottery'));
        $class->setAttributes(array('class'=>''));
        $class->setLinkAttributes(array('class'=>''));
//        $this->addIcon($class, array('icon' => 'file', 'inverted'=>false, 'append'=>false ));
        
        $color = $menu->addChild('Color', array('route' => 'pottery'));
        $color->setAttributes(array('class'=>''));
        $color->setLinkAttributes(array('class'=>''));
//        $this->addIcon($color, array('icon' => 'file', 'inverted'=>false, 'append'=>false ));
        
        $firin = $menu->addChild('Firing', array('route' => 'pottery'));
        $firin->setAttributes(array('class'=>''));
        $firin->setLinkAttributes(array('class'=>''));
//        $this->addIcon($firin, array('icon' => 'file', 'inverted'=>false, 'append'=>false ));
        
        $handle = $menu->addChild('Handle', array('route' => 'pottery'));
        $handle->setAttributes(array('class'=>''));
        $handle->setLinkAttributes(array('class'=>''));
//        $this->addIcon($handle, array('icon' => 'file', 'inverted'=>false, 'append'=>false ));
        
        $handpos = $menu->addChild('Handle Position', array('route' => 'pottery'));
        $handpos->setAttributes(array('class'=>''));
        $handpos->setLinkAttributes(array('class'=>''));
//        $this->addIcon($handpos, array('icon' => 'file', 'inverted'=>false, 'append'=>false ));
        
        $incl = $menu->addChild('Inclusion', array('route' => 'pottery'));
        $incl->setAttributes(array('class'=>''));
        $incl->setLinkAttributes(array('class'=>''));
//        $this->addIcon($incl, array('icon' => 'file', 'inverted'=>false, 'append'=>false ));
        
        $inclfre = $menu->addChild('Inclusion Frequency', array('route' => 'pottery'));
        $inclfre->setAttributes(array('class'=>''));
        $inclfre->setLinkAttributes(array('class'=>''));
//        $this->addIcon($inclfre, array('icon' => 'file', 'inverted'=>false, 'append'=>false ));
        
        $inclsiz = $menu->addChild('Inclusion Size', array('route' => 'pottery'));
        $inclsiz->setAttributes(array('class'=>''));
        $inclsiz->setLinkAttributes(array('class'=>''));
//        $this->addIcon($inclsiz, array('icon' => 'file', 'inverted'=>false, 'append'=>false ));
        
        $decopt = $menu->addChild('Decoration Option', array('route' => 'pottery'));
        $decopt->setAttributes(array('class'=>''));
        $decopt->setLinkAttributes(array('class'=>''));
//        $this->addIcon($decopt, array('icon' => 'file', 'inverted'=>false, 'append'=>false ));
        
        $wall = $menu->addChild('Wall', array('route' => 'pottery'));
        $wall->setAttributes(array('class'=>''));
        $wall->setLinkAttributes(array('class'=>''));
//        $this->addIcon($wall, array('icon' => 'file', 'inverted'=>false, 'append'=>false ));
        
        $upwall = $menu->addChild('Upper Wall', array('route' => 'pottery'));
        $upwall->setAttributes(array('class'=>''));
        $upwall->setLinkAttributes(array('class'=>''));
//        $this->addIcon($upwall, array('icon' => 'file', 'inverted'=>false, 'append'=>false ));
        
        $lowwal = $menu->addChild('Lower Wall', array('route' => 'pottery'));
        $lowwal->setAttributes(array('class'=>''));
        $lowwal->setLinkAttributes(array('class'=>''));
//        $this->addIcon($lowwal, array('icon' => 'file', 'inverted'=>false, 'append'=>false ));
        
        $neck = $menu->addChild('Neck', array('route' => 'pottery'));
        $neck->setAttributes(array('class'=>''));
        $neck->setLinkAttributes(array('class'=>''));
//        $this->addIcon($neck, array('icon' => 'file', 'inverted'=>false, 'append'=>false ));
        
        $preser = $menu->addChild('Preservation', array('route' => 'pottery'));
        $preser->setAttributes(array('class'=>''));
        $preser->setLinkAttributes(array('class'=>''));
//        $this->addIcon($preser, array('icon' => 'file', 'inverted'=>false, 'append'=>false ));
        
        $rim = $menu->addChild('Rim', array('route' => 'pottery'));
        $rim->setAttributes(array('class'=>''));
        $rim->setLinkAttributes(array('class'=>''));
//        $this->addIcon($rim, array('icon' => 'file', 'inverted'=>false, 'append'=>false ));
        
        $shape = $menu->addChild('Shape', array('route' => 'pottery'));
        $shape->setAttributes(array('class'=>''));
        $shape->setLinkAttributes(array('class'=>''));
//        $this->addIcon($shape, array('icon' => 'file', 'inverted'=>false, 'append'=>false ));
        
        $spout = $menu->addChild('Spout', array('route' => 'pottery'));
        $spout->setAttributes(array('class'=>''));
        $spout->setLinkAttributes(array('class'=>''));
//        $this->addIcon($spout, array('icon' => 'file', 'inverted'=>false, 'append'=>false ));
        
        $spoutpo = $menu->addChild('Spout Position', array('route' => 'pottery'));
        $spoutpo->setAttributes(array('class'=>''));
        $spoutpo->setLinkAttributes(array('class'=>''));
//        $this->addIcon($spoutpo, array('icon' => 'file', 'inverted'=>false, 'append'=>false ));
        
        $surf = $menu->addChild('Surface Treatment Option', array('route' => 'pottery'));
        $surf->setAttributes(array('class'=>''));
        $surf->setLinkAttributes(array('class'=>''));
//        $this->addIcon($surf, array('icon' => 'file', 'inverted'=>false, 'append'=>false ));
        
        $tec = $menu->addChild('Technique', array('route' => 'pottery'));
        $tec->setAttributes(array('class'=>''));
        $tec->setLinkAttributes(array('class'=>''));
//        $this->addIcon($tec, array('icon' => 'file', 'inverted'=>false, 'append'=>false ));
        return $menu;
    }
    
    private function createVocsSample($menu) {
        
        $base = $menu->addChild('Type Sample', array('route' => 'samplevoc_vocsampletype'));
        $base->setAttributes(array('class'=>''));
        $base->setLinkAttributes(array('class'=>''));
//        $this->addIcon($base, array('icon' => 'file', 'inverted'=>false, 'append'=>false ));
        return $menu;
    }
    
    public function createVocsPotteryMenu(Request $request) {
//        die(var_dump($request));
        $menu = $this->factory->createItem('root', array(
            'stacked' => true,
            'pull-left' => true,
            'pills' => true
        ));
//        $menu->setChildrenAttribute('class', 'nav show-menu');
        if($this->role_pottery)
            return $this->createVocsPottery($menu);
        if($this->role_object)
            return $this->createVocsObject($menu);
        if($this->role_sample)
            return $this->createVocsSample($menu);
        
        return $menu;
    }

}