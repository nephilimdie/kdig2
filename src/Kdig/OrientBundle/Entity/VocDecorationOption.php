<?php

/**
 * Description of ArchaelogicalBundle 
 *
 * @ author Stefano Bassetto <stefano.bassetto@gmail.com>
 */

namespace Kdig\ArchaelogicalBundle\Entity;

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
     * @ORM\ManyToOne(targetEntity="Kdig\ArchaelogicalBundle\Entity\VocPotteryDecorationin", inversedBy="decorationoption")
     */
    private $decorationin;
    /**
     * @ORM\ManyToOne(targetEntity="Kdig\ArchaelogicalBundle\Entity\VocPotteryDecorationout", inversedBy="decorationoption")
     */
    private $decorationout;
    /**
     * @ORM\ManyToOne(targetEntity="Kdig\ArchaelogicalBundle\Entity\VocPotteryDecorationinout", inversedBy="decorationoption")
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
     */
    public function setName($name)
    {
        $this->name = $name;
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
     */
    public function setNumber($number)
    {
        $this->number = $number;
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
     * @param text $remarks
     */
    public function setRemarks($remarks)
    {
        $this->remarks = $remarks;
    }

    /**
     * Get remarks
     *
     * @return text 
     */
    public function getRemarks()
    {
        return $this->remarks;
    }

    /**
     * Set created
     *
     * @param datetime $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * Get created
     *
     * @return datetime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param datetime $updated
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    }

    /**
     * Get updated
     *
     * @return datetime 
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
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
     */
    public function setIsPublic($isPublic)
    {
        $this->isPublic = $isPublic;
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
     */
    public function setIsDelete($isDelete)
    {
        $this->isDelete = $isDelete;
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
     * @param Kdig\ArchaelogicalBundle\Entity\VocPotteryDecorationin $decorationin
     */
    public function setDecorationin(\Kdig\ArchaelogicalBundle\Entity\VocPotteryDecorationin $decorationin)
    {
        $this->decorationin = $decorationin;
    }

    /**
     * Get decorationin
     *
     * @return Kdig\ArchaelogicalBundle\Entity\VocPotteryDecorationin 
     */
    public function getDecorationin()
    {
        return $this->decorationin;
    }

    /**
     * Set decorationout
     *
     * @param Kdig\ArchaelogicalBundle\Entity\VocPotteryDecorationout $decorationout
     */
    public function setDecorationout(\Kdig\ArchaelogicalBundle\Entity\VocPotteryDecorationout $decorationout)
    {
        $this->decorationout = $decorationout;
    }

    /**
     * Get decorationout
     *
     * @return Kdig\ArchaelogicalBundle\Entity\VocPotteryDecorationout 
     */
    public function getDecorationout()
    {
        return $this->decorationout;
    }

    /**
     * Set decorationinout
     *
     * @param Kdig\ArchaelogicalBundle\Entity\VocPotteryDecorationinout $decorationinout
     */
    public function setDecorationinout(\Kdig\ArchaelogicalBundle\Entity\VocPotteryDecorationinout $decorationinout)
    {
        $this->decorationinout = $decorationinout;
    }

    /**
     * Get decorationinout
     *
     * @return Kdig\ArchaelogicalBundle\Entity\VocPotteryDecorationinout 
     */
    public function getDecorationinout()
    {
        return $this->decorationinout;
    }
    
    public function __tostring() 
    {
        return $this->getName();
    }
}