<?php

namespace Kdig\ArchaeologicalBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Kdig\ArchaeologicalBundle\Entity\Us;

class LoadUsData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $vocustype = new Us();
        $vocustype->setName('0001');
        $vocustype->setSite($this->getReference('pitt-vocustype'));
        $vocustype->setSite($this->getReference('karke-site'));
        $vocustype->setIsPublic(true);
        $manager->persist($vocustype);

        $vocustype2 = new Us();
        $vocustype2->setName('0002');
        $vocustype2->setTypeus($this->getReference('locus-vocustype'));
        $vocustype2->setSite($this->getReference('karke-site'));
        $vocustype2->setIsPublic(true);
        $manager->persist($vocustype2);
        
        $vocustype3 = new Us();
        $vocustype3->setName('0003');
        $vocustype3->setTypeus($this->getReference('locus-vocustype'));
        $vocustype3->setSite($this->getReference('karke-site'));
        $vocustype3->setIsPublic(true);
        $manager->persist($vocustype3);

        $manager->flush();
    }
    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 7; // the order in which fixtures will be loaded
    }
}