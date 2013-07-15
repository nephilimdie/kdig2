<?php

namespace Kdig\ArchaeologicalBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Kdig\ArchaeologicalBundle\Entity\Site;

class LoadSiteData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $site = new Site();
        $site->setName('Karke');
        $site->setCampagna('2013');
        $site->setSigla('kh.');
        $site->setIsPublic(true);

        $manager->persist($site);
        $manager->flush();
        
        $this->addReference('karke-site', $site);
    }
    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 4; // the order in which fixtures will be loaded
    }
}