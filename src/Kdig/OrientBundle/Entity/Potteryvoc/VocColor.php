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
 * @ORM\Table(name="voc_color", schema="public")
 * @Gedmo\Loggable
 */
class VocColor {
    
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
     * @ORM\OneToMany(targetEntity="Kdig\OrientBundle\Entity\Potteryvoc\VocPotteryDecorationin", mappedBy="color")
     */
    private $vocpotdecin;
    
    /**
     * @ORM\OneToMany(targetEntity="Kdig\OrientBundle\Entity\Potteryvoc\VocPotteryDecorationinout", mappedBy="color")
     */
    private $vocpotdecinout;
    
    /**
     * @ORM\OneToMany(targetEntity="Kdig\OrientBundle\Entity\Potteryvoc\VocPotteryDecorationout", mappedBy="color")
     */
    private $vocpotdecout;
    
    /**
     * @ORM\OneToMany(targetEntity="Kdig\OrientBundle\Entity\Potteryvoc\VocPotterySurfacetratin", mappedBy="color")
     */
    private $pottery_surfacetratin;
    /**
     * @ORM\OneToMany(targetEntity="Kdig\OrientBundle\Entity\Potteryvoc\VocPotterySurfacetratinout", mappedBy="color")
     */
    private $pottery_surfacetratinout;
    /**
     * @ORM\OneToMany(targetEntity="Kdig\OrientBundle\Entity\Potteryvoc\VocPotterySurfacetratout", mappedBy="color")
     */
    private $pottery_surfacetratout;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->vocpotdecin = new \Doctrine\Common\Collections\ArrayCollection();
        $this->vocpotdecinout = new \Doctrine\Common\Collections\ArrayCollection();
        $this->vocpotdecout = new \Doctrine\Common\Collections\ArrayCollection();
        $this->pottery_surfacetratin = new \Doctrine\Common\Collections\ArrayCollection();
        $this->pottery_surfacetratinout = new \Doctrine\Common\Collections\ArrayCollection();
        $this->pottery_surfacetratout = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set name
     *
     * @param string $name
     * @return VocColor
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
     * @return VocColor
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
     * @return VocColor
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
     * @return VocColor
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
     * @return VocColor
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
     * @return VocColor
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
     * @return VocColor
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
     * @return VocColor
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
     * Add vocpotdecin
     *
     * @param \Kdig\OrientBundle\Entity\Potteryvoc\VocPotteryDecorationin $vocpotdecin
     * @return VocColor
     */
    public function addVocpotdecin(\Kdig\OrientBundle\Entity\Potteryvoc\VocPotteryDecorationin $vocpotdecin)
    {
        $this->vocpotdecin[] = $vocpotdecin;
    
        return $this;
    }

    /**
     * Remove vocpotdecin
     *
     * @param \Kdig\OrientBundle\Entity\Potteryvoc\VocPotteryDecorationin $vocpotdecin
     */
    public function removeVocpotdecin(\Kdig\OrientBundle\Entity\Potteryvoc\VocPotteryDecorationin $vocpotdecin)
    {
        $this->vocpotdecin->removeElement($vocpotdecin);
    }

    /**
     * Get vocpotdecin
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getVocpotdecin()
    {
        return $this->vocpotdecin;
    }

    /**
     * Add vocpotdecinout
     *
     * @param \Kdig\OrientBundle\Entity\Potteryvoc\VocPotteryDecorationinout $vocpotdecinout
     * @return VocColor
     */
    public function addVocpotdecinout(\Kdig\OrientBundle\Entity\Potteryvoc\VocPotteryDecorationinout $vocpotdecinout)
    {
        $this->vocpotdecinout[] = $vocpotdecinout;
    
        return $this;
    }

    /**
     * Remove vocpotdecinout
     *
     * @param \Kdig\OrientBundle\Entity\Potteryvoc\VocPotteryDecorationinout $vocpotdecinout
     */
    public function removeVocpotdecinout(\Kdig\OrientBundle\Entity\Potteryvoc\VocPotteryDecorationinout $vocpotdecinout)
    {
        $this->vocpotdecinout->removeElement($vocpotdecinout);
    }

    /**
     * Get vocpotdecinout
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getVocpotdecinout()
    {
        return $this->vocpotdecinout;
    }

    /**
     * Add vocpotdecout
     *
     * @param \Kdig\OrientBundle\Entity\Potteryvoc\VocPotteryDecorationout $vocpotdecout
     * @return VocColor
     */
    public function addVocpotdecout(\Kdig\OrientBundle\Entity\Potteryvoc\VocPotteryDecorationout $vocpotdecout)
    {
        $this->vocpotdecout[] = $vocpotdecout;
    
        return $this;
    }

    /**
     * Remove vocpotdecout
     *
     * @param \Kdig\OrientBundle\Entity\Potteryvoc\VocPotteryDecorationout $vocpotdecout
     */
    public function removeVocpotdecout(\Kdig\OrientBundle\Entity\Potteryvoc\VocPotteryDecorationout $vocpotdecout)
    {
        $this->vocpotdecout->removeElement($vocpotdecout);
    }

    /**
     * Get vocpotdecout
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getVocpotdecout()
    {
        return $this->vocpotdecout;
    }

    /**
     * Add pottery_surfacetratin
     *
     * @param \Kdig\OrientBundle\Entity\Potteryvoc\VocPotterySurfacetratin $potterySurfacetratin
     * @return VocColor
     */
    public function addPotterySurfacetratin(\Kdig\OrientBundle\Entity\Potteryvoc\VocPotterySurfacetratin $potterySurfacetratin)
    {
        $this->pottery_surfacetratin[] = $potterySurfacetratin;
    
        return $this;
    }

    /**
     * Remove pottery_surfacetratin
     *
     * @param \Kdig\OrientBundle\Entity\Potteryvoc\VocPotterySurfacetratin $potterySurfacetratin
     */
    public function removePotterySurfacetratin(\Kdig\OrientBundle\Entity\Potteryvoc\VocPotterySurfacetratin $potterySurfacetratin)
    {
        $this->pottery_surfacetratin->removeElement($potterySurfacetratin);
    }

    /**
     * Get pottery_surfacetratin
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPotterySurfacetratin()
    {
        return $this->pottery_surfacetratin;
    }

    /**
     * Add pottery_surfacetratinout
     *
     * @param \Kdig\OrientBundle\Entity\Potteryvoc\VocPotterySurfacetratinout $potterySurfacetratinout
     * @return VocColor
     */
    public function addPotterySurfacetratinout(\Kdig\OrientBundle\Entity\Potteryvoc\VocPotterySurfacetratinout $potterySurfacetratinout)
    {
        $this->pottery_surfacetratinout[] = $potterySurfacetratinout;
    
        return $this;
    }

    /**
     * Remove pottery_surfacetratinout
     *
     * @param \Kdig\OrientBundle\Entity\Potteryvoc\VocPotterySurfacetratinout $potterySurfacetratinout
     */
    public function removePotterySurfacetratinout(\Kdig\OrientBundle\Entity\Potteryvoc\VocPotterySurfacetratinout $potterySurfacetratinout)
    {
        $this->pottery_surfacetratinout->removeElement($potterySurfacetratinout);
    }

    /**
     * Get pottery_surfacetratinout
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPotterySurfacetratinout()
    {
        return $this->pottery_surfacetratinout;
    }

    /**
     * Add pottery_surfacetratout
     *
     * @param \Kdig\OrientBundle\Entity\Potteryvoc\VocPotterySurfacetratout $potterySurfacetratout
     * @return VocColor
     */
    public function addPotterySurfacetratout(\Kdig\OrientBundle\Entity\Potteryvoc\VocPotterySurfacetratout $potterySurfacetratout)
    {
        $this->pottery_surfacetratout[] = $potterySurfacetratout;
    
        return $this;
    }

    /**
     * Remove pottery_surfacetratout
     *
     * @param \Kdig\OrientBundle\Entity\Potteryvoc\VocPotterySurfacetratout $potterySurfacetratout
     */
    public function removePotterySurfacetratout(\Kdig\OrientBundle\Entity\Potteryvoc\VocPotterySurfacetratout $potterySurfacetratout)
    {
        $this->pottery_surfacetratout->removeElement($potterySurfacetratout);
    }

    /**
     * Get pottery_surfacetratout
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPotterySurfacetratout()
    {
        return $this->pottery_surfacetratout;
    }
    
    public function __tostring() 
    {
        return (string)$this->getName();
    }
}