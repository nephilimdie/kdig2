<?php

namespace Kdig\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Acme\HelloBundle\Entity\User;

class LoadUserGroupData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $userGroupAdmin = new UserGroup();
        $userGroupAdmin->setUser($this->getReference('admin-user'));
        $userGroupAdmin->setGroup($this->getReference('admin-group'));

        $manager->persist($userGroupAdmin);
        $manager->flush();
    }
    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 3; // the order in which fixtures will be loaded
    }
}