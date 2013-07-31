<?php

/**
 * Description of ArchaelogicalBundle
 *
 * @ author Stefano Bassetto <stefano.bassetto@gmail.com>
 */

namespace Kdig\OrientBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

use Symfony\Component\Validator\Constraints as Assert;
use APY\DataGridBundle\Grid\Mapping as GRID;

/**
 * @ORM\Entity
 * @ORM\Table(name="photolist", schema="public")
 * @Gedmo\Loggable
 */
class Photolist {
    
    /**
     * @ORM\Id
     * @ORM\Column( type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Gedmo\Versioned
     */
    private $id;
    
    /**
     * @Gedmo\Versioned
     * @ORM\Column(nullable=true, length=1024, type="text")
     */
    private $remarks;
    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(nullable=true, name="created", type="datetime")
     */
    private $created;

    /**
     * @Gedmo\Versioned
     * @ORM\Column(nullable=true, name="updated", type="datetime")
     * @Gedmo\Timestampable(on="update")
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
     * @ORM\Column(nullable=true, name="is_merged", type="boolean")
     */
    private $isMerged=false;

    /**
     * @ORM\ManyToOne(targetEntity="VocMachine", inversedBy="photolist")
     * @ORM\JoinColumn(nullable=true, name="vocmachine_id", referencedColumnName="id", onDelete="SET NULL")
     * @Assert\NotBlank()
     */
    protected $vocmachine;
    
    /**
     * @Gedmo\Versioned
     * @ORM\Column(nullable=true, length=10, type="integer")
     */
    private $fromnumber;
    
    /**
     * @Gedmo\Versioned
     * @ORM\Column(nullable=true, length=10, type="integer")
     */
    private $tonumber;
    
    /** 
     * @ORM\ManyToMany(targetEntity="Kdig\OrientBundle\Entity\Object")
     * @ORM\JoinTable(name="photolists_Objects",
     *      joinColumns={@ORM\JoinColumn(name="photolist_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="object_id", referencedColumnName="id")}
     *      )
     */
    private $object;
    
    /** 
     * @ORM\ManyToMany(targetEntity="Kdig\OrientBundle\Entity\Pottery")
     * @ORM\JoinTable(name="photolists_Potterys",
     *      joinColumns={@ORM\JoinColumn(name="photolist_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="pottery_id", referencedColumnName="id")}
     *      )
     */
    private $pottery;
    
    /** 
     * @ORM\ManyToMany(targetEntity="Kdig\OrientBundle\Entity\Sample")
     * @ORM\JoinTable(name="photolists_Samples",
     *      joinColumns={@ORM\JoinColumn(name="photolist_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="sample_id", referencedColumnName="id")}
     *      )
     */
    private $sample;
    
    /** 
     * @ORM\ManyToMany(targetEntity="Kdig\ArchaeologicalBundle\Entity\Us")
     * @ORM\JoinTable(name="photolists_Uss",
     *      joinColumns={@ORM\JoinColumn(name="photolist_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="us_id", referencedColumnName="id")}
     *      )
     */
    private $us;
    
    /** 
     * @ORM\ManyToMany(targetEntity="Kdig\ArchaeologicalBundle\Entity\Area")
     * @ORM\JoinTable(name="photolists_areas",
     *      joinColumns={@ORM\JoinColumn(name="photolist_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="area_id", referencedColumnName="id")}
     *      )
     */
    private $area;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->object = new \Doctrine\Common\Collections\ArrayCollection();
        $this->pottery = new \Doctrine\Common\Collections\ArrayCollection();
        $this->sample = new \Doctrine\Common\Collections\ArrayCollection();
        $this->us = new \Doctrine\Common\Collections\ArrayCollection();
        $this->area = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set remarks
     *
     * @param string $remarks
     * @return Photolist
     */
    public function setRemarks($remarks)
    {
        $this->remarks = $remarks;
    
        return $this;
    }

    /**
     * Get remarks
     *
     * @return string 
     */
    public function getRemarks()
    {
        return $this->remarks;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Photolist
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
     * @return Photolist
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
     * @return Photolist
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
     * @return Photolist
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
     * @return Photolist
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
     * Set fromnumber
     *
     * @param integer $fromnumber
     * @return Photolist
     */
    public function setFromnumber($fromnumber)
    {
        $this->fromnumber = $fromnumber;
    
        return $this;
    }

    /**
     * Get fromnumber
     *
     * @return integer 
     */
    public function getFromnumber()
    {
        return $this->fromnumber;
    }

    /**
     * Set tonumber
     *
     * @param integer $tonumber
     * @return Photolist
     */
    public function setTonumber($tonumber)
    {
        $this->tonumber = $tonumber;
    
        return $this;
    }

    /**
     * Get tonumber
     *
     * @return integer 
     */
    public function getTonumber()
    {
        return $this->tonumber;
    }

    /**
     * Set vocmachine
     *
     * @param \Kdig\OrientBundle\Entity\VocMachine $vocmachine
     * @return Photolist
     */
    public function setVocmachine(\Kdig\OrientBundle\Entity\VocMachine $vocmachine = null)
    {
        $this->vocmachine = $vocmachine;
    
        return $this;
    }

    /**
     * Get vocmachine
     *
     * @return \Kdig\OrientBundle\Entity\VocMachine 
     */
    public function getVocmachine()
    {
        return $this->vocmachine;
    }

    /**
     * Add object
     *
     * @param \Kdig\OrientBundle\Entity\Object $object
     * @return Photolist
     */
    public function addObject(\Kdig\OrientBundle\Entity\Object $object)
    {
        $this->object[] = $object;
    
        return $this;
    }

    /**
     * Remove object
     *
     * @param \Kdig\OrientBundle\Entity\Object $object
     */
    public function removeObject(\Kdig\OrientBundle\Entity\Object $object)
    {
        $this->object->removeElement($object);
    }

    /**
     * Get object
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getObject()
    {
        return $this->object;
    }

    /**
     * Add pottery
     *
     * @param \Kdig\OrientBundle\Entity\Pottery $pottery
     * @return Photolist
     */
    public function addPottery(\Kdig\OrientBundle\Entity\Pottery $pottery)
    {
        $this->pottery[] = $pottery;
    
        return $this;
    }

    /**
     * Remove pottery
     *
     * @param \Kdig\OrientBundle\Entity\Pottery $pottery
     */
    public function removePottery(\Kdig\OrientBundle\Entity\Pottery $pottery)
    {
        $this->pottery->removeElement($pottery);
    }

    /**
     * Get pottery
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPottery()
    {
        return $this->pottery;
    }

    /**
     * Add sample
     *
     * @param \Kdig\OrientBundle\Entity\Sample $sample
     * @return Photolist
     */
    public function addSample(\Kdig\OrientBundle\Entity\Sample $sample)
    {
        $this->sample[] = $sample;
    
        return $this;
    }

    /**
     * Remove sample
     *
     * @param \Kdig\OrientBundle\Entity\Sample $sample
     */
    public function removeSample(\Kdig\OrientBundle\Entity\Sample $sample)
    {
        $this->sample->removeElement($sample);
    }

    /**
     * Get sample
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSample()
    {
        return $this->sample;
    }

    /**
     * Add us
     *
     * @param \Kdig\ArchaeologicalBundle\Entity\Us $us
     * @return Photolist
     */
    public function addU(\Kdig\ArchaeologicalBundle\Entity\Us $us)
    {
        $this->us[] = $us;
    
        return $this;
    }

    /**
     * Remove us
     *
     * @param \Kdig\ArchaeologicalBundle\Entity\Us $us
     */
    public function removeU(\Kdig\ArchaeologicalBundle\Entity\Us $us)
    {
        $this->us->removeElement($us);
    }

    /**
     * Get us
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUs()
    {
        return $this->us;
    }

    /**
     * Add area
     *
     * @param \Kdig\ArchaeologicalBundle\Entity\Area $area
     * @return Photolist
     */
    public function addArea(\Kdig\ArchaeologicalBundle\Entity\Area $area)
    {
        $this->area[] = $area;
    
        return $this;
    }

    /**
     * Remove area
     *
     * @param \Kdig\ArchaeologicalBundle\Entity\Area $area
     */
    public function removeArea(\Kdig\ArchaeologicalBundle\Entity\Area $area)
    {
        $this->area->removeElement($area);
    }

    /**
     * Get area
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getArea()
    {
        return $this->area;
    }
}