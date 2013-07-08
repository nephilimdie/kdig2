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
     * @ORM\ManyToMany(targetEntity="Media", inversedBy="bucketsheets", cascade={"persist"})
     * @ORM\JoinTable(name="bucketsheet_media",
     *   joinColumns={@ORM\JoinColumn(nullable=true, name="bucketsheet_id", referencedColumnName="id", onDelete="SET NULL")},
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
     * Set isread
     *
     * @param boolean $isread
     */
    public function setIsread($isread)
    {
        $this->isread = $isread;
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
     */
    public function setIsdrawn($isdrawn)
    {
        $this->isdrawn = $isdrawn;
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
     */
    public function setIsnumbered($isnumbered)
    {
        $this->isnumbered = $isnumbered;
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
     */
    public function setIsfiled($isfiled)
    {
        $this->isfiled = $isfiled;
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
     */
    public function setIsphotographed($isphotographed)
    {
        $this->isphotographed = $isphotographed;
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
     * @param Kdig\ArchaelogicalBundle\Entity\Bucket $bucket
     */
    public function setBucket(\Kdig\ArchaelogicalBundle\Entity\Bucket $bucket)
    {
        $this->bucket = $bucket;
    }

    /**
     * Get bucket
     *
     * @return Kdig\ArchaelogicalBundle\Entity\Bucket 
     */
    public function getBucket()
    {
        return $this->bucket;
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