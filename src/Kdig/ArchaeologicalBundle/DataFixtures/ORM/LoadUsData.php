<?php

namespace Kdig\ArchaeologicalBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Kdig\ArchaeologicalBundle\Entity\VocAreaType;

class LoadUsData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $vocustype = new Us();
        $vocustype->setName('Locus');
        $vocustype->setShort('L');
        $vocustype->setIsPublic(true);
        $manager->persist($vocustype);

        $vocustype2 = new VocAreaType();
        $vocustype2->setName('Pitt');
        $vocustype2->setShort('P');
        $vocustype2->setIsPublic(true);
        $manager->persist($vocustype2);

        $manager->flush();
        
        $this->addReference('locus-vocustype', $vocustype);
        $this->addReference('pitt-vocustype', $vocustype2);
    }
    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 7; // the order in which fixtures will be loaded
    }
}