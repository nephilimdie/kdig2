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
 * @ORM\Table(name="bucket", schema="public")
 * @Gedmo\Loggable
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Kdig\ArchaelogicalBundle\Repository\BucketRepository")
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
     * @ORM\ManyToOne(targetEntity="Us", inversedBy="buckets", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true, name="us_id", referencedColumnName="id", onDelete="SET NULL")
     * @GRID\Column(field="us.name", title="Locus", size="40")
     * @GRID\Column(field="us.typeus.name", size="40", title="Type Locus", filter="select")
     * @GRID\Column(field="us.area.name", size="40", title="Area", filter="select")
     */
    private $us;
    
    /**
     * @ORM\OneToMany(targetEntity="Prepottery", mappedBy="bucket", cascade={"persist"})
     */
    private $prepotterys;
    
    /**
     * @ORM\OneToMany(targetEntity="Preobject", mappedBy="bucket", cascade={"persist"})
     */
    private $preobjects;
    
    /**
     * @ORM\OneToMany(targetEntity="Presample", mappedBy="bucket", cascade={"persist"})
     */
    private $presamples;
    
    /**
     *
     * @ORM\ManyToMany(targetEntity="Media", inversedBy="buckets", cascade={"persist"})
     * @ORM\JoinTable(name="bucket_media",
     *   joinColumns={@ORM\JoinColumn(nullable=true, name="bucket_id", referencedColumnName="id", onDelete="SET NULL")},
     *   inverseJoinColumns={@ORM\JoinColumn(nullable=true, name="media_id", referencedColumnName="id", onDelete="SET NULL")}
     * )
     */
    private $media;
    
    /**
     * @ORM\OneToOne(targetEntity="Bucketsheet", inversedBy="bucket", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true, name="bucketsheet_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $bucketsheet;
    
    /**
     * @ORM\Column(nullable=true, type="string", length=255, name="image_name")
     *
     * @var string $imageName
     */
    protected $imageName;
    
    public function __tostring() 
    {
        return $this->getName().'('.$this->getUs().')';
    }
    
    public function __construct()
    {
        $this->prepotterys = new \Doctrine\Common\Collections\ArrayCollection();
        $this->preobjects = new \Doctrine\Common\Collections\ArrayCollection();
        $this->presamples = new \Doctrine\Common\Collections\ArrayCollection();
        $this->media = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    public function prename()
    {
        return $this->getUs()->getSiglafromType();
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
     * Set us
     *
     * @param Kdig\ArchaelogicalBundle\Entity\Us $us
     */
    public function setUs(\Kdig\ArchaelogicalBundle\Entity\Us $us)
    {
        $this->us = $us;
    }

    /**
     * Get us
     *
     * @return Kdig\ArchaelogicalBundle\Entity\Us 
     */
    public function getUs()
    {
        return $this->us;
    }

    /**
     * Add prepotterys
     *
     * @param Kdig\ArchaelogicalBundle\Entity\Prepottery $prepotterys
     */
    public function addPrepottery(\Kdig\ArchaelogicalBundle\Entity\Prepottery $prepotterys)
    {
        $this->prepotterys[] = $prepotterys;
    }

    /**
     * Get prepotterys
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getPrepotterys()
    {
        return $this->prepotterys;
    }
/* da valuatare se utile */
    public function setPrepotterys($prepotterys)
    {
        foreach ($prepotterys as $prepottery) {
            $prepottery->setBucket($this);
        }

        $this->addPrepottery($prepotterys);
    }
    /**
     * Add preobjects
     *
     * @param Kdig\ArchaelogicalBundle\Entity\Preobject $preobjects
     */
    public function addPreobject(\Kdig\ArchaelogicalBundle\Entity\Preobject $preobjects)
    {
        $this->preobjects[] = $preobjects;
    }

    /**
     * Get preobjects
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getPreobjects()
    {
        return $this->preobjects;
    }

    /**
     * Add presamples
     *
     * @param Kdig\ArchaelogicalBundle\Entity\Presample $presamples
     */
    public function addPresample(\Kdig\ArchaelogicalBundle\Entity\Presample $presamples)
    {
        $this->presamples[] = $presamples;
    }

    /**
     * Get presamples
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getPresamples()
    {
        return $this->presamples;
    }

    /**
     * Set bucketsheet
     *
     * @param Kdig\ArchaelogicalBundle\Entity\Bucketsheet $bucketsheet
     */
    public function setBucketsheet(\Kdig\ArchaelogicalBundle\Entity\Bucketsheet $bucketsheet)
    {
        $this->bucketsheet = $bucketsheet;
    }

    /**
     * Get bucketsheet
     *
     * @return Kdig\ArchaelogicalBundle\Entity\Bucketsheet 
     */
    public function getBucketsheet()
    {
        return $this->bucketsheet;
    }


    /**
     * Set imageName
     *
     * @param string $imageName
     */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;
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