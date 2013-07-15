<?php

namespace Kdig\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Kdig\UserBundle\Entity\Group;

class LoadGroupData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $groupAdmin = new Group();
        $groupAdmin->setName('admin');
        $manager->persist($groupAdmin);
        
        $groupPottery = new Group();
        $groupPottery->setName('gruppoCeramica');
        $groupPottery->setRoles(array('ROLE_USER','ROLE_POTTERY','ROLE_ARCHAEOLOGY','ROLE_MEDIA'));
        $manager->persist($groupPottery);
        
        
        $manager->flush();
        
        $this->addReference('group-admin', $groupAdmin);
    }
    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 2; // the order in which fixtures will be loaded
    }
}