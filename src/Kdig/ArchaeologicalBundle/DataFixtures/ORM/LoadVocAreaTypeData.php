<?php

namespace Kdig\ArchaeologicalBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Kdig\ArchaeologicalBundle\Entity\VocAreaType;

class LoadVocAreaTypeData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $vocareatype = new VocAreaType();
        $vocareatype->setName('Area');
        $vocareatype->setIsPublic(true);

        $manager->persist($vocareatype);
        $manager->flush();
        
        $this->addReference('area-vocareatype', $vocareatype);
    }
    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 5; // the order in which fixtures will be loaded
    }
}