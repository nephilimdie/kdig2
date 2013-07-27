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
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use APY\DataGridBundle\Grid\Mapping as GRID;

/**
 * @ORM\Entity
 * @ORM\Table(name="us", schema="public")
 * @Gedmo\Loggable
 * @ORM\Entity(repositoryClass="Kdig\ArchaeologicalBundle\Repository\UsRepository")
 * @UniqueEntity("name")
 * @GRID\Source(columns="id, site.name, area.name, typeus.name, name, remarks, created")
 */
class Us {
    
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
     * @GRID\Column(size="40", title="SU definition")
     */
    private $name;
    
    /**
     * @ORM\Column(nullable=true, length=64, type="string")
     */
    private $sigla;
    
    /**
     * @Gedmo\Versioned
     * @ORM\Column(nullable=true, length=1024, type="text")
     * @GRID\Column(title="Description")
     */
    private $remarks;
    
    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(nullable=true, name="created", type="datetime")
     * @GRID\Column(type="date", size="40", filter="select", title="Created")
     */
    private $created;

    /**
     * @Gedmo\Versioned
     * @ORM\Column(nullable=true, name="updated", type="datetime")
     * @Gedmo\Timestampable(on="update")
     * @GRID\Column(title="Created", size="100",visible=true, type="datetime")
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
     * @ORM\ManyToOne(targetEntity="Area", inversedBy="uss", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true, name="area_id", referencedColumnName="id", onDelete="SET NULL")
     * @GRID\Column(field="area.name",size="40", title="Area", filter="select")
     */
    private $area;
    
    /**
     * @ORM\ManyToOne(targetEntity="Site", inversedBy="uss", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true, name="site_id", referencedColumnName="id", onDelete="SET NULL")
     * @GRID\Column(field="site.name", title="Exacavation campaign", filter="select")
     */
    private $site;
    
    /**
     * @ORM\ManyToOne(targetEntity="VocUsType", inversedBy="us")       
     * @ORM\JoinColumn(nullable=true, name="us_id", referencedColumnName="id", onDelete="SET NULL")
     * @GRID\Column(field="typeus.name", title="SU Type", filter="select")
     */
    protected $typeus;
    
    /**
     * @ORM\OneToMany(targetEntity="Kdig\OrientBundle\Entity\Bucket", mappedBy="us")
     */
    private $buckets;
    
    /**
     *
     * @ORM\ManyToMany(targetEntity="Kdig\MediaBundle\Entity\Media", inversedBy="uss", cascade={"persist"})
     * @ORM\JoinTable(name="us_media",
     *   joinColumns={@ORM\JoinColumn(nullable=true, name="us_id", referencedColumnName="id")},
     *   inverseJoinColumns={@ORM\JoinColumn(nullable=true, name="media_id", referencedColumnName="id")}
     * )
     */
    private $media;
    
    /**
     * @ORM\OneToMany(targetEntity="Matrix", mappedBy="fromuss", cascade={"persist"})
     * @ GRID\Column(field="relationsfrom.typerelation", type="array", title="Stratigrafical relations")
     */
    protected $relationsfrom;
    
    /**
     * @ORM\OneToMany(targetEntity="Matrix", mappedBy="touss", cascade={"persist"})
     */
    protected $relationsto;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->buckets = new \Doctrine\Common\Collections\ArrayCollection();
        $this->media = new \Doctrine\Common\Collections\ArrayCollection();
        $this->relationsfrom = new \Doctrine\Common\Collections\ArrayCollection();
        $this->relationsto = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    public function __tostring() 
    {
        return (string)$this->getName().'('.$this->getSigla().')';
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
     * @return Us
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
     * Set sigla
     *
     * @param string $sigla
     * @return Us
     */
    public function setSigla($sigla)
    {
        $this->sigla = $sigla;
    
        return $this;
    }

    /**
     * Get sigla
     *
     * @return string 
     */
    public function getSigla()
    {
        return $this->sigla;
    }

    /**
     * Set remarks
     *
     * @param string $remarks
     * @return Us
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
     * @return Us
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
     * @return Us
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
     * @return Us
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
     * @return Us
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
     * @return Us
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
     * Set area
     *
     * @param \Kdig\ArchaeologicalBundle\Entity\Area $area
     * @return Us
     */
    public function setArea(\Kdig\ArchaeologicalBundle\Entity\Area $area = null)
    {
        $this->area = $area;
    
        return $this;
    }

    /**
     * Get area
     *
     * @return \Kdig\ArchaeologicalBundle\Entity\Area 
     */
    public function getArea()
    {
        return $this->area;
    }

    /**
     * Set site
     *
     * @param \Kdig\ArchaeologicalBundle\Entity\Site $site
     * @return Us
     */
    public function setSite(\Kdig\ArchaeologicalBundle\Entity\Site $site = null)
    {
        $this->site = $site;
    
        return $this;
    }

    /**
     * Get site
     *
     * @return \Kdig\ArchaeologicalBundle\Entity\Site 
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * Set typeus
     *
     * @param \Kdig\ArchaeologicalBundle\Entity\VocUsType $typeus
     * @return Us
     */
    public function setTypeus(\Kdig\ArchaeologicalBundle\Entity\VocUsType $typeus = null)
    {
        $this->typeus = $typeus;
    
        return $this;
    }

    /**
     * Get typeus
     *
     * @return \Kdig\ArchaeologicalBundle\Entity\VocUsType 
     */
    public function getTypeus()
    {
        return $this->typeus;
    }

    /**
     * Add buckets
     *
     * @param \Kdig\OrientBundle\Entity\Bucket $buckets
     * @return Us
     */
    public function addBucket(\Kdig\OrientBundle\Entity\Bucket $buckets)
    {
        $this->buckets[] = $buckets;
    
        return $this;
    }

    /**
     * Remove buckets
     *
     * @param \Kdig\OrientBundle\Entity\Bucket $buckets
     */
    public function removeBucket(\Kdig\OrientBundle\Entity\Bucket $buckets)
    {
        $this->buckets->removeElement($buckets);
    }

    /**
     * Get buckets
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBuckets()
    {
        return $this->buckets;
    }

    /**
     * Add media
     *
     * @param \Kdig\MediaBundle\Entity\Media $media
     * @return Us
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
     * Add relationsfrom
     *
     * @param \Kdig\ArchaeologicalBundle\Entity\Matrix $relationsfrom
     * @return Us
     */
    public function addRelationsfrom(\Kdig\ArchaeologicalBundle\Entity\Matrix $relationsfrom)
    {
        $this->relationsfrom[] = $relationsfrom;
    
        return $this;
    }

    /**
     * Remove relationsfrom
     *
     * @param \Kdig\ArchaeologicalBundle\Entity\Matrix $relationsfrom
     */
    public function removeRelationsfrom(\Kdig\ArchaeologicalBundle\Entity\Matrix $relationsfrom)
    {
        $this->relationsfrom->removeElement($relationsfrom);
    }

    /**
     * Get relationsfrom
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRelationsfrom()
    {
        return $this->relationsfrom;
    }

    /**
     * Add relationsto
     *
     * @param \Kdig\ArchaeologicalBundle\Entity\Matrix $relationsto
     * @return Us
     */
    public function addRelationsto(\Kdig\ArchaeologicalBundle\Entity\Matrix $relationsto)
    {
        $this->relationsto[] = $relationsto;
    
        return $this;
    }

    /**
     * Remove relationsto
     *
     * @param \Kdig\ArchaeologicalBundle\Entity\Matrix $relationsto
     */
    public function removeRelationsto(\Kdig\ArchaeologicalBundle\Entity\Matrix $relationsto)
    {
        $this->relationsto->removeElement($relationsto);
    }

    /**
     * Get relationsto
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRelationsto()
    {
        return $this->relationsto;
    }
}