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
 * @ORM\Table(name="voc_surface_trat_option", schema="public")
 * @Gedmo\Loggable
 */
class VocSurfaceTratOption {
    
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
     * @ORM\ManyToOne(targetEntity="Kdig\OrientBundle\Entity\Potteryvoc\VocPotterySurfacetratin", inversedBy="vocsurfacetratoption", cascade={"persist"})
     */
    private $surfacein;
    
    /**
     * @ORM\ManyToOne(targetEntity="Kdig\OrientBundle\Entity\Potteryvoc\VocPotterySurfacetratinout", inversedBy="vocsurfacetratoption", cascade={"persist"})
     */
    private $surfaceinout;
    
    /**
     * @ORM\ManyToOne(targetEntity="Kdig\OrientBundle\Entity\Potteryvoc\VocPotterySurfacetratout", inversedBy="vocsurfacetratoption", cascade={"persist"})
     */
    private $surfaceout;


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
     * @return VocSurfaceTratOption
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
     * @return VocSurfaceTratOption
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
     * @return VocSurfaceTratOption
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
     * @return VocSurfaceTratOption
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
     * @return VocSurfaceTratOption
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
     * @return VocSurfaceTratOption
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
     * @return VocSurfaceTratOption
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
     * @return VocSurfaceTratOption
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
     * Set surfacein
     *
     * @param \Kdig\OrientBundle\Entity\Potteryvoc\VocPotterySurfacetratin $surfacein
     * @return VocSurfaceTratOption
     */
    public function setSurfacein(\Kdig\OrientBundle\Entity\Potteryvoc\VocPotterySurfacetratin $surfacein = null)
    {
        $this->surfacein = $surfacein;
    
        return $this;
    }

    /**
     * Get surfacein
     *
     * @return \Kdig\OrientBundle\Entity\Potteryvoc\VocPotterySurfacetratin 
     */
    public function getSurfacein()
    {
        return $this->surfacein;
    }

    /**
     * Set surfaceinout
     *
     * @param \Kdig\OrientBundle\Entity\Potteryvoc\VocPotterySurfacetratinout $surfaceinout
     * @return VocSurfaceTratOption
     */
    public function setSurfaceinout(\Kdig\OrientBundle\Entity\Potteryvoc\VocPotterySurfacetratinout $surfaceinout = null)
    {
        $this->surfaceinout = $surfaceinout;
    
        return $this;
    }

    /**
     * Get surfaceinout
     *
     * @return \Kdig\OrientBundle\Entity\Potteryvoc\VocPotterySurfacetratinout 
     */
    public function getSurfaceinout()
    {
        return $this->surfaceinout;
    }

    /**
     * Set surfaceout
     *
     * @param \Kdig\OrientBundle\Entity\Potteryvoc\VocPotterySurfacetratout $surfaceout
     * @return VocSurfaceTratOption
     */
    public function setSurfaceout(\Kdig\OrientBundle\Entity\Potteryvoc\VocPotterySurfacetratout $surfaceout = null)
    {
        $this->surfaceout = $surfaceout;
    
        return $this;
    }

    /**
     * Get surfaceout
     *
     * @return \Kdig\OrientBundle\Entity\Potteryvoc\VocPotterySurfacetratout 
     */
    public function getSurfaceout()
    {
        return $this->surfaceout;
    }
    
    public function __tostring() 
    {
        return (string)$this->getName();
    }
}