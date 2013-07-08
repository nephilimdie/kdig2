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
     * @ORM\OneToMany(targetEntity="Kdig\ArchaelogicalBundle\Entity\VocPotteryDecorationin", mappedBy="color", cascade={"persist"})
     */
    private $vocpotdecin;
    
    /**
     * @ORM\OneToMany(targetEntity="Kdig\ArchaelogicalBundle\Entity\VocPotteryDecorationinout", mappedBy="color", cascade={"persist"})
     */
    private $vocpotdecinout;
    
    /**
     * @ORM\OneToMany(targetEntity="Kdig\ArchaelogicalBundle\Entity\VocPotteryDecorationout", mappedBy="color", cascade={"persist"})
     */
    private $vocpotdecout;
    
    /**
     * @ORM\OneToMany(targetEntity="Kdig\ArchaelogicalBundle\Entity\VocPotterySurfacetratin", mappedBy="color")
     */
    private $pottery_surfacetratin;
    /**
     * @ORM\OneToMany(targetEntity="Kdig\ArchaelogicalBundle\Entity\VocPotterySurfacetratinout", mappedBy="color")
     */
    private $pottery_surfacetratinout;
    /**
     * @ORM\OneToMany(targetEntity="Kdig\ArchaelogicalBundle\Entity\VocPotterySurfacetratout", mappedBy="color")
     */
    private $pottery_surfacetratout;

    public function __tostring() 
    {
        return $this->getName();
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
     * Set vocpotdecin
     *
     * @param Kdig\ArchaelogicalBundle\Entity\VocPotteryDecorationin $vocpotdecin
     */
    public function setVocpotdecin(\Kdig\ArchaelogicalBundle\Entity\VocPotteryDecorationin $vocpotdecin)
    {
        $this->vocpotdecin = $vocpotdecin;
    }

    /**
     * Get vocpotdecin
     *
     * @return Kdig\ArchaelogicalBundle\Entity\VocPotteryDecorationin 
     */
    public function getVocpotdecin()
    {
        return $this->vocpotdecin;
    }

    /**
     * Set vocpotdecinout
     *
     * @param Kdig\ArchaelogicalBundle\Entity\VocPotteryDecorationinout $vocpotdecinout
     */
    public function setVocpotdecinout(\Kdig\ArchaelogicalBundle\Entity\VocPotteryDecorationinout $vocpotdecinout)
    {
        $this->vocpotdecinout = $vocpotdecinout;
    }

    /**
     * Get vocpotdecinout
     *
     * @return Kdig\ArchaelogicalBundle\Entity\VocPotteryDecorationinout 
     */
    public function getVocpotdecinout()
    {
        return $this->vocpotdecinout;
    }

    /**
     * Set vocpotdecout
     *
     * @param Kdig\ArchaelogicalBundle\Entity\VocPotteryDecorationout $vocpotdecout
     */
    public function setVocpotdecout(\Kdig\ArchaelogicalBundle\Entity\VocPotteryDecorationout $vocpotdecout)
    {
        $this->vocpotdecout = $vocpotdecout;
    }

    /**
     * Get vocpotdecout
     *
     * @return Kdig\ArchaelogicalBundle\Entity\VocPotteryDecorationout 
     */
    public function getVocpotdecout()
    {
        return $this->vocpotdecout;
    }

    /**
     * Set pottery_surfacetratin
     *
     * @param Kdig\ArchaelogicalBundle\Entity\VocPotterySurfacetratin $potterySurfacetratin
     */
    public function setPotterySurfacetratin(\Kdig\ArchaelogicalBundle\Entity\VocPotterySurfacetratin $potterySurfacetratin)
    {
        $this->pottery_surfacetratin = $potterySurfacetratin;
    }

    /**
     * Get pottery_surfacetratin
     *
     * @return Kdig\ArchaelogicalBundle\Entity\VocPotterySurfacetratin 
     */
    public function getPotterySurfacetratin()
    {
        return $this->pottery_surfacetratin;
    }

    /**
     * Set pottery_surfacetratinout
     *
     * @param Kdig\ArchaelogicalBundle\Entity\VocPotterySurfacetratinout $potterySurfacetratinout
     */
    public function setPotterySurfacetratinout(\Kdig\ArchaelogicalBundle\Entity\VocPotterySurfacetratinout $potterySurfacetratinout)
    {
        $this->pottery_surfacetratinout = $potterySurfacetratinout;
    }

    /**
     * Get pottery_surfacetratinout
     *
     * @return Kdig\ArchaelogicalBundle\Entity\VocPotterySurfacetratinout 
     */
    public function getPotterySurfacetratinout()
    {
        return $this->pottery_surfacetratinout;
    }

    /**
     * Set pottery_surfacetratout
     *
     * @param Kdig\ArchaelogicalBundle\Entity\VocPotterySurfacetratout $potterySurfacetratout
     */
    public function setPotterySurfacetratout(\Kdig\ArchaelogicalBundle\Entity\VocPotterySurfacetratout $potterySurfacetratout)
    {
        $this->pottery_surfacetratout = $potterySurfacetratout;
    }

    /**
     * Get pottery_surfacetratout
     *
     * @return Kdig\ArchaelogicalBundle\Entity\VocPotterySurfacetratout 
     */
    public function getPotterySurfacetratout()
    {
        return $this->pottery_surfacetratout;
    }
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
     * Add vocpotdecin
     *
     * @param Kdig\ArchaelogicalBundle\Entity\VocPotteryDecorationin $vocpotdecin
     */
    public function addVocPotteryDecorationin(\Kdig\ArchaelogicalBundle\Entity\VocPotteryDecorationin $vocpotdecin)
    {
        $this->vocpotdecin[] = $vocpotdecin;
    }

    /**
     * Add vocpotdecinout
     *
     * @param Kdig\ArchaelogicalBundle\Entity\VocPotteryDecorationinout $vocpotdecinout
     */
    public function addVocPotteryDecorationinout(\Kdig\ArchaelogicalBundle\Entity\VocPotteryDecorationinout $vocpotdecinout)
    {
        $this->vocpotdecinout[] = $vocpotdecinout;
    }

    /**
     * Add vocpotdecout
     *
     * @param Kdig\ArchaelogicalBundle\Entity\VocPotteryDecorationout $vocpotdecout
     */
    public function addVocPotteryDecorationout(\Kdig\ArchaelogicalBundle\Entity\VocPotteryDecorationout $vocpotdecout)
    {
        $this->vocpotdecout[] = $vocpotdecout;
    }

    /**
     * Add pottery_surfacetratin
     *
     * @param Kdig\ArchaelogicalBundle\Entity\VocPotterySurfacetratin $potterySurfacetratin
     */
    public function addVocPotterySurfacetratin(\Kdig\ArchaelogicalBundle\Entity\VocPotterySurfacetratin $potterySurfacetratin)
    {
        $this->pottery_surfacetratin[] = $potterySurfacetratin;
    }

    /**
     * Add pottery_surfacetratinout
     *
     * @param Kdig\ArchaelogicalBundle\Entity\VocPotterySurfacetratinout $potterySurfacetratinout
     */
    public function addVocPotterySurfacetratinout(\Kdig\ArchaelogicalBundle\Entity\VocPotterySurfacetratinout $potterySurfacetratinout)
    {
        $this->pottery_surfacetratinout[] = $potterySurfacetratinout;
    }

    /**
     * Add pottery_surfacetratout
     *
     * @param Kdig\ArchaelogicalBundle\Entity\VocPotterySurfacetratout $potterySurfacetratout
     */
    public function addVocPotterySurfacetratout(\Kdig\ArchaelogicalBundle\Entity\VocPotterySurfacetratout $potterySurfacetratout)
    {
        $this->pottery_surfacetratout[] = $potterySurfacetratout;
    }
}