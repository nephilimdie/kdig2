<?php

namespace Kdig\UserBundle\Entity;

use Sonata\UserBundle\Entity\BaseGroup as BaseGroup;
use Doctrine\ORM\Mapping as ORM;

use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_group")
 * 
 * @category   Kdig_Entities
 * @package    Entity
 */
class Group extends BaseGroup
{        
    /**
     * @ORM\ManyToMany(targetEntity="Kdig\ArchaeologicalBundle\Entity\Area", mappedBy="groups", cascade={"persist"})
     */ 
    private $areas;
    /**
     * @ORM\OneToMany(targetEntity="Kdig\UserBundle\Entity\Group", mappedBy="slectedgroup", cascade={"persist"})
     */
    private $userprofilegroup;

    public function __construct()
    {
        parent::__construct(null, $roles = array());
        $this->areas = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add areas
     *
     * @param Kdig\ArchaelogicalBundle\Entity\Area $areas
     */
    public function addArea(\Kdig\ArchaeologicalBundle\Entity\Area $areas)
    {
        $this->areas[] = $areas;
    }

    /**
     * Get areas
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getAreas()
    {
        return $this->areas;
    }

    /**
     * Add userprofilegroup
     *
     * @param Kdig\UserBundle\Entity\Group $userprofilegroup
     */
    public function addGroup(\Kdig\UserBundle\Entity\Group $userprofilegroup)
    {
        $this->userprofilegroup[] = $userprofilegroup;
    }

    /**
     * Get userprofilegroup
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getUserprofilegroup()
    {
        return $this->userprofilegroup;
    }
    
}
