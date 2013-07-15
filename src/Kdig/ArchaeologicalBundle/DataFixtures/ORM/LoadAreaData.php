<?php

namespace Kdig\ArchaeologicalBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Kdig\ArchaeologicalBundle\Entity\Area;

class LoadAreaData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $area = new Area();
        $area->setName('A');
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