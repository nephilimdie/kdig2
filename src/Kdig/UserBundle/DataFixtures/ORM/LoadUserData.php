<?php

namespace Kdig\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Kdig\UserBundle\Entity\User;

class LoadUserData implements FixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $userAdmin = new User();
        $userAdmin->setUsername('admin');
        $userAdmin->getUsernameCanonical('admin');
        $userAdmin->setPlainPassword('kdig');
        $userAdmin->setEmail('admin@kdig.com');
        $userAdmin->setEmailCanonical('admin@kdig.com');
        $userAdmin->setEnabled(true);
        $userAdmin->setRoles(array('ROLE_ADMIN', 'ROLE_SUPER_ADMIN'));
        $userAdmin->setPermissions(array('VIEW', 'EDIT', 'CREATE', 'DELETE'));
       	$userAdmin->addGroupUser($this->getReference('group-admin'));
        $userAdmin->setSuperAdmin(true);

        $manager->persist($userAdmin);
        $manager->flush();
    }
    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1; // the order in which fixtures will be loaded
    }
}