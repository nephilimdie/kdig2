<?php

/**
 * Description of ArchaelogicalBundle 
 *
 * @ author Stefano Bassetto <stefano.bassetto@gmail.com>
 */

namespace Kdig\OrientBundle\Entity\Potteryvoc;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

use Symfony\Component\Validator\Constraints as Assert;
use APY\DataGridBundle\Grid\Mapping as GRID;

/**
 * @ORM\Entity
 * @ORM\Table(name="voc_decoration_option", schema="public")
 * @Gedmo\Loggable
 */
class VocDecorationOption {
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Gedmo\Versioned
     */
    private $id;
    
    /**
     * @Gedmo\Versioned
     * @ORM\Column(nullable=true, length=64, type="string")
     * 
     */
    private $name;
    
    /**
     * @Gedmo\Versioned
     * @ORM\Column(nullable=true, length=64, type="integer")
     */
    private $number;
    
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
     * @ORM\ManyToOne(targetEntity="Kdig\OrientBundle\Entity\Potteryvoc\VocPotteryDecorationin", inversedBy="decorationoption")
     */
    private $decorationin;
    /**
     * @ORM\ManyToOne(targetEntity="Kdig\OrientBundle\Entity\Potteryvoc\VocPotteryDecorationout", inversedBy="decorationoption")
     */
    private $decorationout;
    /**
     * @ORM\ManyToOne(targetEntity="Kdig\OrientBundle\Entity\Potteryvoc\VocPotteryDecorationinout", inversedBy="decorationoption")
     */
    private $decorationinout;

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
     * Set name
     *
     * @param string $name
     * @return VocDecorationOption
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set number
     *
     * @param integer $number
     * @return VocDecorationOption
     */
    public function setNumber($number)
    {
        $this->number = $number;
    
        return $this;
    }

    /**
     * Get number
     *
     * @return integer 
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set remarks
     *
     * @param string $remarks
     * @return VocDecorationOption
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
     * @return VocDecorationOption
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
     * @return VocDecorationOption
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
     * @return VocDecorationOption
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
     * @return VocDecorationOption
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
     * @return VocDecorationOption
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
     * Set decorationin
     *
     * @param \Kdig\OrientBundle\Entity\Potteryvoc\VocPotteryDecorationin $decorationin
     * @return VocDecorationOption
     */
    public function setDecorationin(\Kdig\OrientBundle\Entity\Potteryvoc\VocPotteryDecorationin $decorationin = null)
    {
        $this->decorationin = $decorationin;
    
        return $this;
    }

    /**
     * Get decorationin
     *
     * @return \Kdig\OrientBundle\Entity\Potteryvoc\VocPotteryDecorationin 
     */
    public function getDecorationin()
    {
        return $this->decorationin;
    }

    /**
     * Set decorationout
     *
     * @param \Kdig\OrientBundle\Entity\Potteryvoc\VocPotteryDecorationout $decorationout
     * @return VocDecorationOption
     */
    public function setDecorationout(\Kdig\OrientBundle\Entity\Potteryvoc\VocPotteryDecorationout $decorationout = null)
    {
        $this->decorationout = $decorationout;
    
        return $this;
    }

    /**
     * Get decorationout
     *
     * @return \Kdig\OrientBundle\Entity\Potteryvoc\VocPotteryDecorationout 
     */
    public function getDecorationout()
    {
        return $this->decorationout;
    }

    /**
     * Set decorationinout
     *
     * @param \Kdig\OrientBundle\Entity\Potteryvoc\VocPotteryDecorationinout $decorationinout
     * @return VocDecorationOption
     */
    public function setDecorationinout(\Kdig\OrientBundle\Entity\Potteryvoc\VocPotteryDecorationinout $decorationinout = null)
    {
        $this->decorationinout = $decorationinout;
    
        return $this;
    }

    /**
     * Get decorationinout
     *
     * @return \Kdig\OrientBundle\Entity\Potteryvoc\VocPotteryDecorationinout 
     */
    public function getDecorationinout()
    {
        return $this->decorationinout;
    }
    
    public function __tostring() 
    {
        return (string)$this->getName();
    }
}