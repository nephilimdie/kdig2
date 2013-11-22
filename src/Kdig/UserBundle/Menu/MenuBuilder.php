<?php

namespace Kdig\UserBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContextInterface;

class MenuBuilder
{
    protected $securityContext;
    protected $isLoggedIn = null;
    protected $isSuperAdmin = null;
    protected $usr = null;
    
    private $factory;

    public function __construct(FactoryInterface $factory, SecurityContextInterface $securityContext)
    {
//        parent::__construct($factory);

        $this->factory = $factory;
        
        $this->securityContext = $securityContext;
        $this->isLoggedIn = $this->securityContext->isGranted('IS_AUTHENTICATED_FULLY');
        if($this->isLoggedIn) {
            $this->usr = $securityContext->getToken()->getUser();
        }
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
}