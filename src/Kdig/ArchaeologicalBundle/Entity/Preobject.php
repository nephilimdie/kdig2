<?php

/**
 * Description of ArchaelogicalBundle 
 *
 * @ author Stefano Bassetto <stefano.bassetto@gmail.com>
 */

namespace Kdig\ArchaeologicalBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

use Symfony\Component\Validator\Constraints as Assert;
use APY\DataGridBundle\Grid\Mapping as GRID;

/**
 * @ORM\Entity
 * @ORM\Table(name="pre_object", schema="public")
 * @Gedmo\Loggable
 * @GRID\Source(columns="id, bucket.us.area.name, bucket.us.typeus.name, bucket.us.name, bucket.name, name, isActive, isDelete, isPublic, created")
 * @ORM\Entity(repositoryClass="Kdig\ArchaeologicalBundle\Repository\PreobjectRepository")
 */
class Preobject {
    
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
     *
     * @ORM\ManyToMany(targetEntity="Kdig\MediaBundle\Entty\Media", inversedBy="preobjects", cascade={"persist"})
     * @ORM\JoinTable(name="preobject_media",
     *   joinColumns={@ORM\JoinColumn(nullable=true, name="preobject_id", referencedColumnName="id", onDelete="SET NULL")},
     *   inverseJoinColumns={@ORM\JoinColumn(nullable=true, name="media_id", referencedColumnName="id", onDelete="SET NULL")}
     * )
     */
    public $media;

    /**
     * @ORM\OneToOne(targetEntity="Object", inversedBy="preobject", cascade={"persist"}, orphanRemoval=true)
     * @ORM\JoinColumn(nullable=true, name="object_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $object;
    
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
     * @ ORM\ManyToOne(targetEntity="Bucket", inversedBy="preobjects", cascade={"persist"})
     * @ ORM\JoinColumn(nullable=true, name="bucket_id", referencedColumnName="id", onDelete="SET NULL")
     * @ GRID\Column(field="bucket.name", title="Bucket")
     * @ GRID\Column(field="bucket.us.name", title="Locus", size="40")
     * @ GRID\Column(field="bucket.us.typeus.name", title="Type Locus", filter="select", size="40")
     * @ GRID\Column(field="bucket.us.area.name", title="Area", filter="select", size="40")
     */
//    private $bucket;
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
     * @return Preobject
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
     * @return Preobject
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
     * @return Preobject
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
     * @return Preobject
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
     * @return Preobject
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
     * @return Preobject
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
     * @return Preobject
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
     * Add media
     *
     * @param \Kdig\MediaBundle\Entty\Media $media
     * @return Preobject
     */
    public function addMedia(\Kdig\MediaBundle\Entty\Media $media)
    {
        $this->media[] = $media;
    
        return $this;
    }

    /**
     * Remove media
     *
     * @param \Kdig\MediaBundle\Entty\Media $media
     */
    public function removeMedia(\Kdig\MediaBundle\Entty\Media $media)
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
     * Set object
     *
     * @param \Kdig\ArchaeologicalBundle\Entity\Object $object
     * @return Preobject
     */
    public function setObject(\Kdig\ArchaeologicalBundle\Entity\Object $object = null)
    {
        $this->object = $object;
    
        return $this;
    }

    /**
     * Get object
     *
     * @return \Kdig\ArchaeologicalBundle\Entity\Object 
     */
    public function getObject()
    {
        return $this->object;
    }
}