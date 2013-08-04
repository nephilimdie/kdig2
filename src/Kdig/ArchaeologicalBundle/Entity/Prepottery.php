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
// DON'T forget this use statement!!!
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="pre_pottery", schema="public")
 * @UniqueEntity("name")
 * @ORM\Entity(repositoryClass="Kdig\ArchaeologicalBundle\Repository\PrepotteryRepository")
 * @Gedmo\Loggable
 * @GRID\Source(columns="id, bucket.us.area.name, bucket.us.typeus.name, bucket.us.name, bucket.name, name, isActive, isDelete, isPublic, created")
 */
class Prepottery {
    
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
     * @ORM\Column(nullable=false, length=64, type="string", unique=true)
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
     * @ORM\ManyToOne(targetEntity="Kdig\OrientBundle\Entity\Bucket", inversedBy="prepotterys", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true, name="bucket_id", referencedColumnName="id")
     * @GRID\Column(field="bucket.name", title="Bucket")
     * @GRID\Column(field="bucket.us.name", title="Locus", size="40")
     * @GRID\Column(field="bucket.us.typeus.name", title="Type Locus", filter="select", size="40")
     * @GRID\Column(field="bucket.us.area.name", title="Area", filter="select", size="40")
     */
    private $bucket;
    
    /**
     *
     * @ORM\ManyToMany(targetEntity="Kdig\MediaBundle\Entity\Media", inversedBy="prepotterys", cascade={"persist"})
     * @ORM\JoinTable(name="prepottery_media",
     *   joinColumns={@ORM\JoinColumn(nullable=true, name="prepottery_id", referencedColumnName="id", onDelete="SET NULL")},
     *   inverseJoinColumns={@ORM\JoinColumn(nullable=true, name="media_id", referencedColumnName="id", onDelete="SET NULL")}
     * )
     */
    private $media;

    /**
     * @ORM\OneToOne(targetEntity="Kdig\OrientBundle\Entity\Pottery", inversedBy="prepottery", orphanRemoval=true, cascade={"persist"})
     * @ORM\JoinColumn(nullable=true, name="pottery_id", referencedColumnName="id")
     */
    private $pottery;
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
     * @return Prepottery
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
     * @return Prepottery
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
     * @return Prepottery
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
     * @return Prepottery
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
     * @return Prepottery
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
     * @return Prepottery
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
     * @return Prepottery
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
     * Set bucket
     *
     * @param \Kdig\OrientBundle\Entity\Bucket $bucket
     * @return Prepottery
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
     * @return Prepottery
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
     * Set pottery
     *
     * @param \Kdig\OrientBundle\Entity\Pottery $pottery
     * @return Prepottery
     */
    public function setPottery(\Kdig\OrientBundle\Entity\Pottery $pottery = null)
    {
        $this->pottery = $pottery;
    
        return $this;
    }

    /**
     * Get pottery
     *
     * @return \Kdig\OrientBundle\Entity\Pottery 
     */
    public function getPottery()
    {
        return $this->pottery;
    }
}