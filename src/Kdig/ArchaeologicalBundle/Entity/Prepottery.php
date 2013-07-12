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
     * @ORM\Column(nullable=true, length=64, type="string")
     * @Assert\NotBlank()
     * @GRID\Column(size="40", title="Name", unique=true)
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
     * @ORM\ManyToOne(targetEntity="Bucket", inversedBy="prepotterys", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true, name="bucket_id", referencedColumnName="id", onDelete="SET NULL")
     * @GRID\Column(field="bucket.name", title="Bucket")
     * @GRID\Column(field="bucket.us.name", title="Locus", size="40")
     * @GRID\Column(field="bucket.us.typeus.name", title="Type Locus", filter="select", size="40")
     * @GRID\Column(field="bucket.us.area.name", title="Area", filter="select", size="40")
     */
    private $bucket;
    
    /**
     *
     * @ORM\ManyToMany(targetEntity="Media", inversedBy="prepotterys", cascade={"persist"})
     * @ORM\JoinTable(name="prepottery_media",
     *   joinColumns={@ORM\JoinColumn(nullable=true, name="prepottery_id", referencedColumnName="id", onDelete="SET NULL")},
     *   inverseJoinColumns={@ORM\JoinColumn(nullable=true, name="media_id", referencedColumnName="id", onDelete="SET NULL")}
     * )
     */
    private $media;

    /**
     * @ORM\OneToOne(targetEntity="Pottery", inversedBy="prepottery", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true, name="pottery_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $pottery;
    
    
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
     * add bucket
     *
     * @param Kdig\ArchaelogicalBundle\Entity\Bucket $bucket
     *
    public function addTask(\Kdig\ArchaelogicalBundle\Entity\Bucket $bucket)
    {
        if (!$this->bucket->contains($bucket)) {
            $this->bucket->add($bucket);
        }
    }*/
    
    /**
     * Set pottery
     *
     * @param Kdig\ArchaelogicalBundle\Entity\Pottery $pottery
     */
    public function setPottery(\Kdig\ArchaelogicalBundle\Entity\Pottery $pottery)
    {
        $this->pottery = $pottery;
    }

    /**
     * Get pottery
     *
     * @return Kdig\ArchaelogicalBundle\Entity\Pottery 
     */
    public function getPottery()
    {
        return $this->pottery;
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

    /**
     * Remove media
     *
     * @param \Kdig\ArchaeologicalBundle\Entity\Media $media
     */
    public function removeMedia(\Kdig\ArchaeologicalBundle\Entity\Media $media)
    {
        $this->media->removeElement($media);
    }
}