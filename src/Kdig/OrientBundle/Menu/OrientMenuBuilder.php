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
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'row-fluid');
        
        $base = $menu->addChild('Base', array('route' => 'pottery'));
        $base->setAttributes(array('class'=>'span2'));
        $base->setLinkAttributes(array('class'=>'btn'));
        $this->addIcon($base, array('icon' => 'file', 'inverted'=>false, 'append'=>false ));
        
        $class = $menu->addChild('Class', array('route' => 'pottery'));
        $class->setAttributes(array('class'=>'span2'));
        $class->setLinkAttributes(array('class'=>'btn'));
        $this->addIcon($class, array('icon' => 'file', 'inverted'=>false, 'append'=>false ));
        
        $color = $menu->addChild('Color', array('route' => 'pottery'));
        $color->setAttributes(array('class'=>'span2'));
        $color->setLinkAttributes(array('class'=>'btn'));
        $this->addIcon($color, array('icon' => 'file', 'inverted'=>false, 'append'=>false ));
        
        $firin = $menu->addChild('Firing', array('route' => 'pottery'));
        $firin->setAttributes(array('class'=>'span2'));
        $firin->setLinkAttributes(array('class'=>'btn'));
        $this->addIcon($firin, array('icon' => 'file', 'inverted'=>false, 'append'=>false ));
        
        $handle = $menu->addChild('Handle', array('route' => 'pottery'));
        $handle->setAttributes(array('class'=>'span2'));
        $handle->setLinkAttributes(array('class'=>'btn'));
        $this->addIcon($handle, array('icon' => 'file', 'inverted'=>false, 'append'=>false ));
        
        $handpos = $menu->addChild('Handle Position', array('route' => 'pottery'));
        $handpos->setAttributes(array('class'=>'span2'));
        $handpos->setLinkAttributes(array('class'=>'btn'));
        $this->addIcon($handpos, array('icon' => 'file', 'inverted'=>false, 'append'=>false ));
        
        $incl = $menu->addChild('Inclusion', array('route' => 'pottery'));
        $incl->setAttributes(array('class'=>'span2'));
        $incl->setLinkAttributes(array('class'=>'btn'));
        $this->addIcon($incl, array('icon' => 'file', 'inverted'=>false, 'append'=>false ));
        
        $inclfre = $menu->addChild('Inclusion Frequency', array('route' => 'pottery'));
        $inclfre->setAttributes(array('class'=>'span2'));
        $inclfre->setLinkAttributes(array('class'=>'btn'));
        $this->addIcon($inclfre, array('icon' => 'file', 'inverted'=>false, 'append'=>false ));
        
        $inclsiz = $menu->addChild('Inclusion Size', array('route' => 'pottery'));
        $inclsiz->setAttributes(array('class'=>'span2'));
        $inclsiz->setLinkAttributes(array('class'=>'btn'));
        $this->addIcon($inclsiz, array('icon' => 'file', 'inverted'=>false, 'append'=>false ));
        
        $decopt = $menu->addChild('Decoration Option', array('route' => 'pottery'));
        $decopt->setAttributes(array('class'=>'span2'));
        $decopt->setLinkAttributes(array('class'=>'btn'));
        $this->addIcon($decopt, array('icon' => 'file', 'inverted'=>false, 'append'=>false ));
        
        $wall = $menu->addChild('Wall', array('route' => 'pottery'));
        $wall->setAttributes(array('class'=>'span2'));
        $wall->setLinkAttributes(array('class'=>'btn'));
        $this->addIcon($wall, array('icon' => 'file', 'inverted'=>false, 'append'=>false ));
        
        $upwall = $menu->addChild('Upper Wall', array('route' => 'pottery'));
        $upwall->setAttributes(array('class'=>'span2'));
        $upwall->setLinkAttributes(array('class'=>'btn'));
        $this->addIcon($upwall, array('icon' => 'file', 'inverted'=>false, 'append'=>false ));
        
        $lowwal = $menu->addChild('Lower Wall', array('route' => 'pottery'));
        $lowwal->setAttributes(array('class'=>'span2'));
        $lowwal->setLinkAttributes(array('class'=>'btn'));
        $this->addIcon($lowwal, array('icon' => 'file', 'inverted'=>false, 'append'=>false ));
        
        $neck = $menu->addChild('Neck', array('route' => 'pottery'));
        $neck->setAttributes(array('class'=>'span2'));
        $neck->setLinkAttributes(array('class'=>'btn'));
        $this->addIcon($neck, array('icon' => 'file', 'inverted'=>false, 'append'=>false ));
        
        $preser = $menu->addChild('Preservation', array('route' => 'pottery'));
        $preser->setAttributes(array('class'=>'span2'));
        $preser->setLinkAttributes(array('class'=>'btn'));
        $this->addIcon($preser, array('icon' => 'file', 'inverted'=>false, 'append'=>false ));
        
        $rim = $menu->addChild('Rim', array('route' => 'pottery'));
        $rim->setAttributes(array('class'=>'span2'));
        $rim->setLinkAttributes(array('class'=>'btn'));
        $this->addIcon($rim, array('icon' => 'file', 'inverted'=>false, 'append'=>false ));
        
        $shape = $menu->addChild('Shape', array('route' => 'pottery'));
        $shape->setAttributes(array('class'=>'span2'));
        $shape->setLinkAttributes(array('class'=>'btn'));
        $this->addIcon($shape, array('icon' => 'file', 'inverted'=>false, 'append'=>false ));
        
        $spout = $menu->addChild('Spout', array('route' => 'pottery'));
        $spout->setAttributes(array('class'=>'span2'));
        $spout->setLinkAttributes(array('class'=>'btn'));
        $this->addIcon($spout, array('icon' => 'file', 'inverted'=>false, 'append'=>false ));
        
        $spoutpo = $menu->addChild('Spout Position', array('route' => 'pottery'));
        $spoutpo->setAttributes(array('class'=>'span2'));
        $spoutpo->setLinkAttributes(array('class'=>'btn'));
        $this->addIcon($spoutpo, array('icon' => 'file', 'inverted'=>false, 'append'=>false ));
        
        $surf = $menu->addChild('Surface Treatment Option', array('route' => 'pottery'));
        $surf->setAttributes(array('class'=>'span2'));
        $surf->setLinkAttributes(array('class'=>'btn'));
        $this->addIcon($surf, array('icon' => 'file', 'inverted'=>false, 'append'=>false ));
        
        $tec = $menu->addChild('Technique', array('route' => 'pottery'));
        $tec->setAttributes(array('class'=>'span2'));
        $tec->setLinkAttributes(array('class'=>'btn'));
        $this->addIcon($tec, array('icon' => 'file', 'inverted'=>false, 'append'=>false ));
        
        
        return $menu;
    }

}