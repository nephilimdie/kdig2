<?php

namespace Kdig\ArchaeologicalBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Acme\HelloBundle\Entity\User;

class LoadAreaData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $area = new Area();
        $area->setName('A');
        $area->setCampagna('2013');
        $area->setSigla('kh.');
        $area->setFromrefbucket('0');
        $area->setTorefbucket('99');
        $area->setFromrefus('200');
        $area->setTorefus('299');
        $area->setType($this->getReference('area-vocareatype'));
        $area->setIsPublic(true);

        $manager->persist($site);
        $manager->flush();
    }
    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 6; // the order in which fixtures will be loaded
    }
}