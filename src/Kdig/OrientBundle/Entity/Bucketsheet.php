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
 * @ORM\Table(name="bucketsheet", schema="public")
 * @Gedmo\Loggable
 */
class Bucketsheet {
    
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
     * @ORM\OneToOne(targetEntity="Bucket", inversedBy="bucketsheet", cascade={"persist"})
     */
    private $bucket;
    
    /**
     * @Gedmo\Versioned
     * @ORM\Column(nullable=true, name="is_read", type="boolean")
     */
    private $isread;
    
    /**
     * @Gedmo\Versioned
     * @ORM\Column(nullable=true, name="is_drawn", type="boolean")
     */
    private $isdrawn;
    
    /**
     * @Gedmo\Versioned
     * @ORM\Column(nullable=true, name="is_numbered", type="boolean")
     */
    private $isnumbered;
    
    /**
     * @Gedmo\Versioned
     * @ORM\Column(nullable=true, name="is_filed", type="boolean")
     */
    private $isfiled;
    
    /**
     * @Gedmo\Versioned
     * @ORM\Column(nullable=true, name="is_photographed", type="boolean")
     */
    private $isphotographed;
    /**
     *
     * @ORM\ManyToMany(targetEntity="Kdig\MediaBundle\Entity\Media", inversedBy="bucketsheets", cascade={"persist"})
     * @ORM\JoinTable(name="bucketsheet_media",
     *   joinColumns={@ORM\JoinColumn(nullable=true, name="bucketsheet_id", referencedColumnName="id", onDelete="SET NULL")},
     *   inverseJoinColumns={@ORM\JoinColumn(nullable=true, name="media_id", referencedColumnName="id", onDelete="SET NULL")}
     * )
     */
    private $media;
    /**
     * Constructor
     */
    public function __construct()
    {
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
     * @return Bucketsheet
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
     * @return Bucketsheet
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
     * @return Bucketsheet
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
     * @return Bucketsheet
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
     * @return Bucketsheet
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
     * @return Bucketsheet
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
     * @return Bucketsheet
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
     * Set isread
     *
     * @param boolean $isread
     * @return Bucketsheet
     */
    public function setIsread($isread)
    {
        $this->isread = $isread;
    
        return $this;
    }

    /**
     * Get isread
     *
     * @return boolean 
     */
    public function getIsread()
    {
        return $this->isread;
    }

    /**
     * Set isdrawn
     *
     * @param boolean $isdrawn
     * @return Bucketsheet
     */
    public function setIsdrawn($isdrawn)
    {
        $this->isdrawn = $isdrawn;
    
        return $this;
    }

    /**
     * Get isdrawn
     *
     * @return boolean 
     */
    public function getIsdrawn()
    {
        return $this->isdrawn;
    }

    /**
     * Set isnumbered
     *
     * @param boolean $isnumbered
     * @return Bucketsheet
     */
    public function setIsnumbered($isnumbered)
    {
        $this->isnumbered = $isnumbered;
    
        return $this;
    }

    /**
     * Get isnumbered
     *
     * @return boolean 
     */
    public function getIsnumbered()
    {
        return $this->isnumbered;
    }

    /**
     * Set isfiled
     *
     * @param boolean $isfiled
     * @return Bucketsheet
     */
    public function setIsfiled($isfiled)
    {
        $this->isfiled = $isfiled;
    
        return $this;
    }

    /**
     * Get isfiled
     *
     * @return boolean 
     */
    public function getIsfiled()
    {
        return $this->isfiled;
    }

    /**
     * Set isphotographed
     *
     * @param boolean $isphotographed
     * @return Bucketsheet
     */
    public function setIsphotographed($isphotographed)
    {
        $this->isphotographed = $isphotographed;
    
        return $this;
    }

    /**
     * Get isphotographed
     *
     * @return boolean 
     */
    public function getIsphotographed()
    {
        return $this->isphotographed;
    }

    /**
     * Set bucket
     *
     * @param \Kdig\OrientBundle\Entity\Bucket $bucket
     * @return Bucketsheet
     */
    public function setBucket(\Kdig\OrientBundle\Entity\Bucket $bucket = null)
    {
        $this->bucket = $bucket;
    
        return $this;
    }

    /**
     * Get bucket
     *
     * @return \Kdig\OrientBundle\Entity\Bucket 
     */
    public function getBucket()
    {
        return $this->bucket;
    }

    /**
     * Add media
     *
     * @param \Kdig\MediaBundle\Entity\Media $media
     * @return Bucketsheet
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
}