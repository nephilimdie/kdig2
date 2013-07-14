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
}