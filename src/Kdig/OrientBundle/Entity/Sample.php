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
     * @ORM\OneToOne(targetEntity="Presample", inversedBy="sample", cascade={"persist"})
     * @GRID\Column(field="presample.bucket.name", title="Bucket")
     * @GRID\Column(field="presample.bucket.us.name", title="Locus", size="40")
     * @GRID\Column(field="presample.bucket.us.typeus.name", title="Type Locus", filter="select", size="40")
     * @GRID\Column(field="presample.bucket.us.area.name", title="Area", filter="select", size="40")
     */
    private $presample;
    
    /**
     * @ORM\OneToMany(targetEntity="\Kdig\ArchaelogicalBundle\Entity\VocSampleType", mappedBy="sample")
     * @GRID\Column(field="type.name", title="Type")
     * @GRID\Column(field="type.name", title="Type", filter="select")
     */
    protected $type;
    
    /**
     *
     * @ORM\ManyToMany(targetEntity="Media", inversedBy="smaples", cascade={"persist"})
     * @ORM\JoinTable(name="sample_media",
     *   joinColumns={@ORM\JoinColumn(nullable=true, name="sample_id", referencedColumnName="id", onDelete="SET NULL")},
     *   inverseJoinColumns={@ORM\JoinColumn(nullable=true, name="media_id", referencedColumnName="id", onDelete="SET NULL")}
     * )
     */
    private $media;
    
    
    public function __tostring() 
    {
        return $this->getName();
    }
    public function __construct()
    {
        $this->type = new \Doctrine\Common\Collections\ArrayCollection();
        $this->media = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set presample
     *
     * @param Kdig\ArchaelogicalBundle\Entity\Presample $presample
     */
    public function setPresample(\Kdig\ArchaelogicalBundle\Entity\Presample $presample)
    {
        $this->presample = $presample;
    }

    /**
     * Get presample
     *
     * @return Kdig\ArchaelogicalBundle\Entity\Presample 
     */
    public function getPresample()
    {
        return $this->presample;
    }

    /**
     * Add type
     *
     * @param Kdig\ArchaelogicalBundle\Entity\VocSampleType $type
     */
    public function addVocSampleType(\Kdig\ArchaelogicalBundle\Entity\VocSampleType $type)
    {
        $this->type[] = $type;
    }

    /**
     * Get type
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getType()
    {
        return $this->type;
    }


    /**
     * Add media
     *
     * @param Kdig\ArchaelogicalBundle\Entity\Media $media
     */
    public function addMedia(\Kdig\ArchaelogicalBundle\Entity\Media $media)
    {
        $this->media[] = $media;
    }

    /**
     * Get media
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getMedia()
    {
        return $this->media;
    }
}