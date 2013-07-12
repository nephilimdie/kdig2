<?php

/**
 * Description of ArchaelogicalBundle 
 *
 * @ author Stefano Bassetto <stefano.bassetto@gmail.com>
 */

namespace Kdig\ArchaeologicalBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

use Symfony\Component\Validator\Constraints as Assert;
use APY\DataGridBundle\Grid\Mapping as GRID;

/**
 * @ORM\Entity
 * @ORM\Table(name="matrix", schema="public")
 * @Gedmo\Loggable
 */
class Matrix {
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Gedmo\Versioned
     */
    private $id;
    
    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(nullable=true, name="created", type="datetime")
     */
    private $created;

    /**
     * @Gedmo\Versioned
     * @ORM\Column(nullable=true, name="updated", type="datetime")
     * @Gedmo\Timestampable(on="update")
     * @GRID\Column(title="Created", size="100",visible=true, type="datetime")
     */
    private $updated;
    
    /**
     * @Gedmo\Versioned
     * @ORM\Column(nullable=true, name="is_active", type="boolean")
     */
    private $isActive=true;
    
    /**
     * @Gedmo\Versioned
     * @ORM\Column(nullable=true, name="is_public", type="boolean")
     */
    private $isPublic=false;
    
    /**
     * @Gedmo\Versioned
     * @ORM\Column(nullable=true, name="is_delete", type="boolean")
     */
    private $isDelete=false;

    /**
     * @ORM\ManyToOne(targetEntity="VocRelation", inversedBy="matrix")
     */
    private $typerelation;

    /** 
     * @ORM\ManyToOne(targetEntity="Us", inversedBy="relationsfrom") 
     */
    private $fromuss;
    
    /** 
     * @ORM\ManyToOne(targetEntity="Us", inversedBy="relationsto") 
     */
    private $touss;
    
    public function __tostring() 
    {
        return $this->getTyperelation().' '.$this->getTouss();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Matrix
     */
    public function setCreated($created)
    {
        $this->created = $created;
    
        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return Matrix
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    
        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime 
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return Matrix
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
    
        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean 
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set isPublic
     *
     * @param boolean $isPublic
     * @return Matrix
     */
    public function setIsPublic($isPublic)
    {
        $this->isPublic = $isPublic;
    
        return $this;
    }

    /**
     * Get isPublic
     *
     * @return boolean 
     */
    public function getIsPublic()
    {
        return $this->isPublic;
    }

    /**
     * Set isDelete
     *
     * @param boolean $isDelete
     * @return Matrix
     */
    public function setIsDelete($isDelete)
    {
        $this->isDelete = $isDelete;
    
        return $this;
    }

    /**
     * Get isDelete
     *
     * @return boolean 
     */
    public function getIsDelete()
    {
        return $this->isDelete;
    }

    /**
     * Set typerelation
     *
     * @param \Kdig\ArchaeologicalBundle\Entity\VocRelation $typerelation
     * @return Matrix
     */
    public function setTyperelation(\Kdig\ArchaeologicalBundle\Entity\VocRelation $typerelation = null)
    {
        $this->typerelation = $typerelation;
    
        return $this;
    }

    /**
     * Get typerelation
     *
     * @return \Kdig\ArchaeologicalBundle\Entity\VocRelation 
     */
    public function getTyperelation()
    {
        return $this->typerelation;
    }

    /**
     * Set fromuss
     *
     * @param \Kdig\ArchaeologicalBundle\Entity\Us $fromuss
     * @return Matrix
     */
    public function setFromuss(\Kdig\ArchaeologicalBundle\Entity\Us $fromuss = null)
    {
        $this->fromuss = $fromuss;
    
        return $this;
    }

    /**
     * Get fromuss
     *
     * @return \Kdig\ArchaeologicalBundle\Entity\Us 
     */
    public function getFromuss()
    {
        return $this->fromuss;
    }

    /**
     * Set touss
     *
     * @param \Kdig\ArchaeologicalBundle\Entity\Us $touss
     * @return Matrix
     */
    public function setTouss(\Kdig\ArchaeologicalBundle\Entity\Us $touss = null)
    {
        $this->touss = $touss;
    
        return $this;
    }

    /**
     * Get touss
     *
     * @return \Kdig\ArchaeologicalBundle\Entity\Us 
     */
    public function getTouss()
    {
        return $this->touss;
    }
}