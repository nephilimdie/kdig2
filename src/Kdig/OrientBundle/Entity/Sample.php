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
 * @ORM\Table(name="sample", schema="public")
 * @Gedmo\Loggable
 * @GRID\Source(columns="id, presample.bucket.us.area.name, presample.bucket.us.typeus.name, presample.bucket.us.name, presample.bucket.name, presample.name, name, type, isActive, isDelete, isPublic, created")
 */
class Sample {
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Gedmo\Versioned
     * @GRID\Column(title="ID", size="50",visible=false)
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
     * @GRID\Column(type="date", size="40", filter="select")
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
     * @ORM\OneToOne(targetEntity="Kdig\ArchaeologicalBundle\Entity\Presample", inversedBy="sample", orphanRemoval=true)
     * @GRID\Column(field="presample.bucket.name", title="Bucket")
     * @GRID\Column(field="presample.bucket.us.name", title="Locus", size="40")
     * @GRID\Column(field="presample.bucket.us.typeus.name", title="Type Locus", filter="select", size="40")
     * @GRID\Column(field="presample.bucket.us.area.name", title="Area", filter="select", size="40")
     */
    private $presample;
    
    /**
     * @ORM\OneToMany(targetEntity="Kdig\OrientBundle\Entity\Samplevoc\VocSampleType", mappedBy="sample")
     * @GRID\Column(field="type.name", title="Type")
     * @GRID\Column(field="type.name", title="Type", filter="select")
     */
    protected $type;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->type = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Sample
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
     * @return Sample
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
     * @return Sample
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
     * @return Sample
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
     * @return Sample
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
     * @return Sample
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
     * Set presample
     *
     * @param \Kdig\ArchaeologicalBundle\Entity\Presample $presample
     * @return Sample
     */
    public function setPresample(\Kdig\ArchaeologicalBundle\Entity\Presample $presample = null)
    {
        $this->presample = $presample;
    
        return $this;
    }

    /**
     * Get presample
     *
     * @return \Kdig\ArchaeologicalBundle\Entity\Presample 
     */
    public function getPresample()
    {
        return $this->presample;
    }

    /**
     * Add type
     *
     * @param \Kdig\OrientBundle\Entity\Samplevoc\VocSampleType $type
     * @return Sample
     */
    public function addType(\Kdig\OrientBundle\Entity\Samplevoc\VocSampleType $type)
    {
        $this->type[] = $type;
    
        return $this;
    }

    /**
     * Remove type
     *
     * @param \Kdig\OrientBundle\Entity\Samplevoc\VocSampleType $type
     */
    public function removeType(\Kdig\OrientBundle\Entity\Samplevoc\VocSampleType $type)
    {
        $this->type->removeElement($type);
    }

    /**
     * Get type
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getType()
    {
        return $this->type;
    }
}