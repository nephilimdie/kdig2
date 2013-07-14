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
    }

    public function createMainMenu(Request $request)
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav');

        $home = $menu->addChild('Home', array('route' => 'default_index'));
        $this->addIcon($home, array('icon' => 'home', 'inverted'=>true, 'append'=>false ));
        $home = $menu->addChild('About', array('route' => 'kdig_archaeological_default_about'));
        $this->addIcon($home, array('icon' => 'info-sign', 'inverted'=>true, 'append'=>false ));
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
        $this->addIcon($dropdown, array('icon' => 'user', 'inverted'=>true, 'append'=>false ));
        if ($this->isLoggedIn) {
            $dropdown->addChild('Logout', array('route' => 'fos_user_security_logout'));
        } else {
            $dropdown->addChild('login', array('route' => 'fos_user_security_login'));
        }
        return $menu;
    }
    
    public function createArchaeologicalMenu(Request $request)
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav nav-pills nav-stacked span1');

        $pot = $menu->addChild('Pottery', array('route' => 'default_index'));
        $this->addIcon($pot, array('icon' => 'user', 'inverted'=>true, 'append'=>false ));
        $obj = $menu->addChild('Object', array('route' => 'default_index'));
        $this->addIcon($obj, array('icon' => 'user', 'inverted'=>true, 'append'=>false ));
        $smp = $menu->addChild('Sample', array('route' => 'default_index'));
        $this->addIcon($smp, array('icon' => 'user', 'inverted'=>true, 'append'=>false ));
        
        $dropdown = $this->createDropdownMenuItem($menu, "Voc", true, array('caret' => true));
        $dropdown->setChildrenAttribute('class', 'leftMenu');
//        $dropdown->setChildrenAttribute('class', 'nav pull-right');
        $dropdown->addChild('Prova', array('route' => 'fos_user_security_logout'));
        $dropdown->addChild('Prova2', array('route' => 'fos_user_security_logout'));
        // object
        // voc obj
        // 
        // pottery
        // voc pottery
        // 
        // sample
        // voc sample
        // 
//        $dropdown = $this->createDropdownMenuItem($menu, "Mehr");
//        $dropdown->addChild('Captain Ränge', array('route' => 'revorix_ranks'));
//        $dropdown->addChild('Schiffs-XP', array('route' => 'revorix_xptool'));

        return $menu;
    }

}