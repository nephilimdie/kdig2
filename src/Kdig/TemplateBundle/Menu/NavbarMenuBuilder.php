<?php

namespace Kdig\TemplateBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Mopa\Bundle\BootstrapBundle\Navbar\AbstractNavbarMenuBuilder;

class NavbarMenuBuilder extends AbstractNavbarMenuBuilder
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

    public function createMainMenu(Request $request)
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav');

        $home = $menu->addChild('Home', array('route' => 'default_index'));
        $this->addIcon($home, array('icon' => 'home', 'inverted'=>false, 'append'=>false ));
        $about = $menu->addChild('About', array('route' => 'kdig_archaeological_default_about'));
        $this->addIcon($about, array('icon' => 'info-sign', 'inverted'=>false, 'append'=>false ));
//        $dropdown = $this->createDropdownMenuItem($menu, "Mehr");
//        $dropdown->addChild('Captain Ränge', array('route' => 'revorix_ranks'));
//        $dropdown->addChild('Schiffs-XP', array('route' => 'revorix_xptool'));

//        $this->addDivider($menu, true);
        return $menu;
    }

    public function createUserSideDropdownMenu(Request $request)
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav pull-right');

        $dropdown = $this->createDropdownMenuItem($menu, "User", true, array('caret' => true));
        if ($this->isLoggedIn) {
            $dropdown->setLabel($this->usr->getUsername());
            if ($this->isSuperAdmin) {
                $dropdown->addChild('Administration', array('route' => 'sonata_admin_dashboard'));
                $this->addDivider($menu, true);
            }
            $dropdown->addChild('Logout', array('route' => 'fos_user_security_logout'));
        } else {
            $dropdown->addChild('login', array('route' => 'fos_user_security_login'));
        }
        $this->addIcon($dropdown, array('icon' => 'user', 'inverted'=>false, 'append'=>false ));
        return $menu;
    }
    public function createSelectGroupMenu(Request $request)
    {
        if ($this->isLoggedIn) { 
            $this->usr->getSlectedgroup();
            $menu = $this->factory->createItem('root');
            $menu->setChildrenAttribute('class', 'nav pull-right');

            $dropdown = $this->createDropdownMenuItem($menu, "Area", true, array('caret' => true));
            foreach ($this->usr->getGroup() as $group)
                $dropdown->addChild($group->getName(), array('route' => 'user_change_group', 'routeParameters' => array('id' => $group->getId())));
            return $menu;
        }
        return false;
    }

    public function createArchaeologicalMenu(Request $request)
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav nav-pills nav-stacked span1');

//        $pot = $menu->addChild('Pottery', array('route' => 'default_index'));
//        $this->addIcon($pot, array('icon' => 'user', 'inverted'=>false, 'append'=>false ));
//        $obj = $menu->addChild('Object', array('route' => 'default_index'));
//        $this->addIcon($obj, array('icon' => 'user', 'inverted'=>false, 'append'=>false ));
//        $smp = $menu->addChild('Sample', array('route' => 'default_index'));
//        $this->addIcon($smp, array('icon' => 'user', 'inverted'=>false, 'append'=>false ));
        
        
        if ($this->role_archaeology) {
            $su = $this->createDropdownMenuItem($menu, "SU", true, array('caret' => true));
            $su->setChildrenAttribute('class', 'leftMenu dropdown-menu');
            $bucket = $this->createDropdownMenuItem($menu, "Bucket", true, array('caret' => true));
            $bucket->setChildrenAttribute('class', 'leftMenu dropdown-menu');
            $obj = $this->createDropdownMenuItem($menu, "Object", true, array('caret' => true));
            $obj->setChildrenAttribute('class', 'leftMenu dropdown-menu');
            $pot = $this->createDropdownMenuItem($menu, "Pottery", true, array('caret' => true));
            $pot->setChildrenAttribute('class', 'leftMenu dropdown-menu');
            $smp = $this->createDropdownMenuItem($menu, "Sample", true, array('caret' => true));
            $smp->setChildrenAttribute('class', 'leftMenu dropdown-menu');
            $media = $this->createDropdownMenuItem($menu, "Media", true, array('caret' => true));
            $media->setChildrenAttribute('class', 'leftMenu dropdown-menu');
            
            $su->addChild('New', array('route' => 'us_new'));
            $su->addChild('List', array('route' => 'us'));
            $bucket->addChild('New', array('route' => 'bucket_new'));
            $bucket->addChild('List', array('route' => 'bucket'));
            $obj->addChild('New', array('route' => 'preobject_new'));
            $obj->addChild('List', array('route' => 'preobject'));
            $pot->addChild('New', array('route' => 'prepottery_new'));
            $pot->addChild('List', array('route' => 'prepottery'));
            $smp->addChild('New', array('route' => 'presample_new'));
            $smp->addChild('List', array('route' => 'presample'));
            $media->addChild('New', array('route' => 'default_index'));
            $media->addChild('List', array('route' => 'default_index'));
        
        } elseif ($this->role_pottery) {
            $su = $this->createDropdownMenuItem($menu, "SU", true, array('caret' => true));
            $su->setChildrenAttribute('class', 'leftMenu dropdown-menu');
            $bucket = $this->createDropdownMenuItem($menu, "Bucket", true, array('caret' => true));
            $bucket->setChildrenAttribute('class', 'leftMenu dropdown-menu');
            $pot = $this->createDropdownMenuItem($menu, "Pottery", true, array('caret' => true));
            $pot->setChildrenAttribute('class', 'leftMenu dropdown-menu');
            $media = $this->createDropdownMenuItem($menu, "Media", true, array('caret' => true));
            $media->setChildrenAttribute('class', 'leftMenu dropdown-menu');
            
            $su->addChild('New', array('route' => 'us_new'));
            $su->addChild('List', array('route' => 'us'));
            $bucket->addChild('New', array('route' => 'bucket_new'));
            $bucket->addChild('List', array('route' => 'bucket'));
            $pot->addChild('New', array('route' => 'pottery_new'));
            $pot->addChild('List', array('route' => 'pottery'));
            $media->addChild('New', array('route' => 'default_index'));
            $media->addChild('List', array('route' => 'default_index'));
            
        } elseif ($this->role_object) {
            $su = $this->createDropdownMenuItem($menu, "SU", true, array('caret' => true));
            $su->setChildrenAttribute('class', 'leftMenu dropdown-menu');
            $bucket = $this->createDropdownMenuItem($menu, "Bucket", true, array('caret' => true));
            $bucket->setChildrenAttribute('class', 'leftMenu dropdown-menu');
            $obj = $this->createDropdownMenuItem($menu, "Object", true, array('caret' => true));
            $obj->setChildrenAttribute('class', 'leftMenu dropdown-menu');
            $media = $this->createDropdownMenuItem($menu, "Media", true, array('caret' => true));
            $media->setChildrenAttribute('class', 'leftMenu dropdown-menu');
            
            $su->addChild('New', array('route' => 'us_new'));
            $su->addChild('List', array('route' => 'us'));
            $bucket->addChild('New', array('route' => 'bucket_new'));
            $bucket->addChild('List', array('route' => 'bucket'));
            $obj->addChild('New', array('route' => 'object_new'));
            $obj->addChild('List', array('route' => 'object'));
            $media->addChild('New', array('route' => 'default_index'));
            $media->addChild('List', array('route' => 'default_index'));
            
        } elseif ($this->role_sample) {
            $su = $this->createDropdownMenuItem($menu, "SU", true, array('caret' => true));
            $su->setChildrenAttribute('class', 'leftMenu dropdown-menu');
            $bucket = $this->createDropdownMenuItem($menu, "Bucket", true, array('caret' => true));
            $bucket->setChildrenAttribute('class', 'leftMenu dropdown-menu');
            $obj = $this->createDropdownMenuItem($menu, "Object", true, array('caret' => true));
            $obj->setChildrenAttribute('class', 'leftMenu dropdown-menu');
            $pot = $this->createDropdownMenuItem($menu, "Pottery", true, array('caret' => true));
            $pot->setChildrenAttribute('class', 'leftMenu dropdown-menu');
            $smp = $this->createDropdownMenuItem($menu, "Sample", true, array('caret' => true));
            $smp->setChildrenAttribute('class', 'leftMenu dropdown-menu');
            $media = $this->createDropdownMenuItem($menu, "Media", true, array('caret' => true));
            $media->setChildrenAttribute('class', 'leftMenu dropdown-menu');
            
            $su->addChild('New', array('route' => 'us_new'));
            $su->addChild('List', array('route' => 'us'));
            $bucket->addChild('New', array('route' => 'bucket_new'));
            $bucket->addChild('List', array('route' => 'bucket'));
            $obj->addChild('New', array('route' => 'preobject_new'));
            $obj->addChild('List', array('route' => 'preobject'));
            $pot->addChild('New', array('route' => 'prepottery_new'));
            $pot->addChild('List', array('route' => 'prepottery'));
            $smp->addChild('New', array('route' => 'presample_new'));
            $smp->addChild('List', array('route' => 'presample'));
            $media->addChild('New', array('route' => 'default_index'));
            $media->addChild('List', array('route' => 'default_index'));
        }

        return $menu;
    }

}