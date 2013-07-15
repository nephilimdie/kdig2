<?php

namespace Kdig\ArchaeologicalBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Kdig\ArchaeologicalBundle\Entity\VocAreaType;

class LoadVocUsTypeData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $vocareatype = new VocAreaType();
        $vocareatype->setName('Locus');
        $vocareatype->setShort('L');
        $vocareatype->setIsPublic(true);

        $manager->persist($vocareatype);
        $manager->flush();
        
        $this->addReference('locus-vocustype', $vocareatype);
    }
    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 7; // the order in which fixtures will be loaded
    }
}