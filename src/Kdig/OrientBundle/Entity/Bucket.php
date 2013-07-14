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
 * @ORM\Table(name="bucket", schema="public")
 * @Gedmo\Loggable
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Kdig\ArchaeologicalBundle\Entity\Repository\BucketRepository")
 * @GRID\Source(columns="id, us.area.name, us.typeus.name, us.name, name, remarks, created")
 */
class Bucket {
    
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
     * @ORM\Column(nullable=true, length=64, type="string")
     * @Assert\NotBlank()
     * @GRID\Column(size="40", title="Name")
     */
    private $name;
    
    /**
     * @Gedmo\Versioned
     * @ORM\Column(nullable=true, length=1024, type="text")
     */
    private $remarks;
    
    /**
     * @ORM\ManyToOne(targetEntity="Kdig\ArchaeologicalBundle\Entity\Us", inversedBy="buckets", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true, name="us_id", referencedColumnName="id", onDelete="SET NULL")
     * @GRID\Column(field="us.name", title="Locus", size="40")
     * @GRID\Column(field="us.typeus.name", size="40", title="Type Locus", filter="select")
     * @GRID\Column(field="us.area.name", size="40", title="Area", filter="select")
     */
    private $us;
    
    /**
     * @ORM\OneToMany(targetEntity="Kdig\ArchaeologicalBundle\Entity\Prepottery", mappedBy="bucket", cascade={"persist"})
     */
    private $prepotterys;
    
    /**
     * @ORM\OneToMany(targetEntity="Kdig\ArchaeologicalBundle\Entity\Preobject", mappedBy="bucket", cascade={"persist"})
     */
    private $preobjects;
    
    /**
     * @ORM\OneToMany(targetEntity="Kdig\ArchaeologicalBundle\Entity\Presample", mappedBy="bucket", cascade={"persist"})
     */
    private $presamples;
    
    /**
     *
     * @ORM\ManyToMany(targetEntity="Kdig\MediaBundle\Entity\Media", inversedBy="buckets", cascade={"persist"})
     * @ORM\JoinTable(name="bucket_media",
     *   joinColumns={@ORM\JoinColumn(nullable=true, name="bucket_id", referencedColumnName="id", onDelete="SET NULL")},
     *   inverseJoinColumns={@ORM\JoinColumn(nullable=true, name="media_id", referencedColumnName="id", onDelete="SET NULL")}
     * )
     */
    private $media;
    
    /**
     * @ORM\OneToOne(targetEntity="Kdig\OrientBundle\Entity\Bucketsheet", inversedBy="bucket", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true, name="bucketsheet_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $bucketsheet;
    
    /**
     * @ORM\Column(nullable=true, type="string", length=255, name="image_name")
     *
     * @var string $imageName
     */
    protected $imageName;
    
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
     * @GRID\Column(visible=false)
     */
    private $isActive=true;
    
    /**
     * @Gedmo\Versioned
     * @ORM\Column(nullable=true, name="is_public", type="boolean")
     * @GRID\Column(visible=false)
     */
    private $isPublic=false;
    
    /**
     * @Gedmo\Versioned
     * @ORM\Column(nullable=true, name="is_delete", type="boolean")
     * @GRID\Column(visible=false)
     */
    private $isDelete=false;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->prepotterys = new \Doctrine\Common\Collections\ArrayCollection();
        $this->preobjects = new \Doctrine\Common\Collections\ArrayCollection();
        $this->presamples = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Bucket
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
     * Set remarks
     *
     * @param string $remarks
     * @return Bucket
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
     * Set imageName
     *
     * @param string $imageName
     * @return Bucket
     */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;
    
        return $this;
    }

    /**
     * Get imageName
     *
     * @return string 
     */
    public function getImageName()
    {
        return $this->imageName;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Bucket
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
     * @return Bucket
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
     * @return Bucket
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
     * @return Bucket
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
     * @return Bucket
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
     * Set us
     *
     * @param \Kdig\ArchaeologicalBundle\Entity\Us $us
     * @return Bucket
     */
    public function setUs(\Kdig\ArchaeologicalBundle\Entity\Us $us = null)
    {
        $this->us = $us;
    
        return $this;
    }

    /**
     * Get us
     *
     * @return \Kdig\ArchaeologicalBundle\Entity\Us 
     */
    public function getUs()
    {
        return $this->us;
    }

    /**
     * Add prepotterys
     *
     * @param \Kdig\ArchaeologicalBundle\Entity\Prepottery $prepotterys
     * @return Bucket
     */
    public function addPrepottery(\Kdig\ArchaeologicalBundle\Entity\Prepottery $prepotterys)
    {
        $this->prepotterys[] = $prepotterys;
    
        return $this;
    }

    /**
     * Remove prepotterys
     *
     * @param \Kdig\ArchaeologicalBundle\Entity\Prepottery $prepotterys
     */
    public function removePrepottery(\Kdig\ArchaeologicalBundle\Entity\Prepottery $prepotterys)
    {
        $this->prepotterys->removeElement($prepotterys);
    }

    /**
     * Get prepotterys
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPrepotterys()
    {
        return $this->prepotterys;
    }

    /**
     * Add preobjects
     *
     * @param \Kdig\ArchaeologicalBundle\Entity\Preobject $preobjects
     * @return Bucket
     */
    public function addPreobject(\Kdig\ArchaeologicalBundle\Entity\Preobject $preobjects)
    {
        $this->preobjects[] = $preobjects;
    
        return $this;
    }

    /**
     * Remove preobjects
     *
     * @param \Kdig\ArchaeologicalBundle\Entity\Preobject $preobjects
     */
    public function removePreobject(\Kdig\ArchaeologicalBundle\Entity\Preobject $preobjects)
    {
        $this->preobjects->removeElement($preobjects);
    }

    /**
     * Get preobjects
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPreobjects()
    {
        return $this->preobjects;
    }

    /**
     * Add presamples
     *
     * @param \Kdig\ArchaeologicalBundle\Entity\Presample $presamples
     * @return Bucket
     */
    public function addPresample(\Kdig\ArchaeologicalBundle\Entity\Presample $presamples)
    {
        $this->presamples[] = $presamples;
    
        return $this;
    }

    /**
     * Remove presamples
     *
     * @param \Kdig\ArchaeologicalBundle\Entity\Presample $presamples
     */
    public function removePresample(\Kdig\ArchaeologicalBundle\Entity\Presample $presamples)
    {
        $this->presamples->removeElement($presamples);
    }

    /**
     * Get presamples
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPresamples()
    {
        return $this->presamples;
    }

    /**
     * Add media
     *
     * @param \Kdig\MediaBundle\Entity\Media $media
     * @return Bucket
     */
    public function addMedia(\Kdig\MediaBundle\Entity\Media $media)
    {
        $this->media[] = $media;
    
        return $this;
    }

    /**
     * Remove media
     *
     * @param \Kdig\MediaBundle\Entity\Media $media
     */
    public function removeMedia(\Kdig\MediaBundle\Entity\Media $media)
    {
        $this->media->removeElement($media);
    }

    /**
     * Get media
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMedia()
    {
        return $this->media;
    }

    /**
     * Set bucketsheet
     *
     * @param \Kdig\OrientBundle\Entity\Bucketsheet $bucketsheet
     * @return Bucket
     */
    public function setBucketsheet(\Kdig\OrientBundle\Entity\Bucketsheet $bucketsheet = null)
    {
        $this->bucketsheet = $bucketsheet;
    
        return $this;
    }

    /**
     * Get bucketsheet
     *
     * @return \Kdig\OrientBundle\Entity\Bucketsheet 
     */
    public function getBucketsheet()
    {
        return $this->bucketsheet;
    }
}