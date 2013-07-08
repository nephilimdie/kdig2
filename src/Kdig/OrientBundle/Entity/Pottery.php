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

use Kdig\ArchaelogicalBundle\Entity\BaseEntity;

use Symfony\Component\Validator\Constraints as Assert;
use APY\DataGridBundle\Grid\Mapping as GRID;

use Sonata\AdminBundle\Admin\Admin;
use Symfony\Component\HttpKernel\Kernel;

/**
 * @ORM\Entity
 * @ORM\Table(name="pottery", schema="public")
 * @Gedmo\Loggable
 * @ORM\HasLifecycleCallbacks
 * @GRID\Source(columns="id,prepottery.bucket.us.site.campagna, prepottery.bucket.us.area.name, typecontext, prepottery.bucket.us.typeus.name, prepottery.bucket.us.name, prepottery.bucket.name, prepottery.name, class.name, shape.name, rim.name, neck.name, wall.name, upperwall.name, lowerwall.name, base.name, handle.name, handleposition.name, spout.name, spoutposition.name, preservation.name, technique.name, firing.name, outercolor, innercolor, fabriccolor, inclusion.name, inclusionsize.name, inclusionfrequency.name, rimdiameter, rimwidth, wallwidth,  maxwalldiameter, bottomwidth, height, basediameter,datation,restored, remarks, created, tcode")
 */
class Pottery {
    
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
     * @ORM\Column(nullable=true,length=1024, type="text")
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
     * @ORM\OneToOne(targetEntity="Prepottery", inversedBy="pottery", cascade={"persist"})
     * @GRID\Column(field="prepottery.name", title="Field", size="40")
     * @GRID\Column(field="prepottery.bucket.us.name", title="Locus", filter="select", size="40")
     * @GRID\Column(field="prepottery.bucket.us.typeus.name", title="Type Locus", filter="select", size="40")
     * @GRID\Column(field="prepottery.bucket.name", title="Bucket", filter="select", size="40")
     * @GRID\Column(field="prepottery.bucket.us.area.name",title="Area", filter="select", size="20")
     * @GRID\Column(field="prepottery.bucket.us.site.campagna",title="Campaign", filter="select", size="20")
     */
    private $prepottery;
    
    /**
     *
     * @ORM\ManyToMany(targetEntity="Media", inversedBy="potterys", cascade={"persist"})
     * @ORM\JoinTable(name="pottery_media",
     *   joinColumns={@ORM\JoinColumn(nullable=true, name="pottery_id", referencedColumnName="id", onDelete="SET NULL")},
     *   inverseJoinColumns={@ORM\JoinColumn(nullable=true, name="media_id", referencedColumnName="id", onDelete="SET NULL")}
     * )
     */
    private $media;
    
    /**
     * @Gedmo\Versioned
     * @ORM\Column(nullable=true, length=64, type="string")
     * @GRID\Column(type="text", size="200")
     */
    private $tcode;  
    
    /**
     * @Gedmo\Versioned
     * @ORM\Column(nullable=true,length=64, type="integer")
     * @GRID\Column(size="40", filter="select", title="Type of context")
    */
    private $typecontext;
    
    /**
     * @ORM\ManyToOne(targetEntity="VocClass", inversedBy="pottery", cascade={"persist"})      
     * @ORM\JoinColumn(nullable=true, referencedColumnName="id", onDelete="SET NULL")
     * @GRID\Column(field="class.name", title="Class", filter="select")
     */
    protected $class;
    
    /**
     * @ORM\ManyToOne(targetEntity="VocShape", inversedBy="pottery", cascade={"persist"})      
     * @ORM\JoinColumn(nullable=true, referencedColumnName="id", onDelete="SET NULL")
     * @GRID\Column(field="shape.name", title="Shape", filter="select")
     */
    protected $shape;
    
    /**
     * @ORM\ManyToOne(targetEntity="VocRim", inversedBy="pottery", cascade={"persist"})      
     * @ORM\JoinColumn(nullable=true, referencedColumnName="id", onDelete="SET NULL")
     * @GRID\Column(field="rim.name", title="Rim", filter="select")
     */
    protected $rim;
    
    /**
     * @ORM\ManyToOne(targetEntity="VocNeck", inversedBy="pottery", cascade={"persist"})      
     * @ORM\JoinColumn(nullable=true, referencedColumnName="id", onDelete="SET NULL")
     * @GRID\Column(field="neck.name", title="Neck", filter="select")
     */
    protected $neck;
    
    /**
     * @ORM\ManyToOne(targetEntity="VocWall", inversedBy="pottery", cascade={"persist"})      
     * @ORM\JoinColumn(nullable=true, referencedColumnName="id", onDelete="SET NULL")
     * @GRID\Column(field="wall.name", title="Wall", filter="select")
     */
    protected $wall;
    
    /**
     * @ORM\ManyToOne(targetEntity="VocUpperWall", inversedBy="pottery", cascade={"persist"})      
     * @ORM\JoinColumn(nullable=true, referencedColumnName="id", onDelete="SET NULL")
     * @GRID\Column(field="upperwall.name", title="Upper Wall", filter="select")
     */
    protected $upperwall;
    
    /**
     * @ORM\ManyToOne(targetEntity="VocLowerWall", inversedBy="pottery", cascade={"persist"})      
     * @ORM\JoinColumn(nullable=true, referencedColumnName="id", onDelete="SET NULL")
     * @GRID\Column(field="lowerwall.name", title="Lower Wall", filter="select")
     */
    protected $lowerwall;
    
    /**
     * @ORM\ManyToOne(targetEntity="VocBase", inversedBy="pottery", cascade={"persist"})      
     * @ORM\JoinColumn(nullable=true, referencedColumnName="id", onDelete="SET NULL")
     * @GRID\Column(field="base.name", title="Base", filter="select")
     */
    protected $base;
    
    /**
     * @ORM\ManyToOne(targetEntity="VocHandle", inversedBy="pottery", cascade={"persist"})      
     * @ORM\JoinColumn(nullable=true, referencedColumnName="id", onDelete="SET NULL")
     * @GRID\Column(field="handle.name", title="Handle", filter="select")
     */
    protected $handle;
    
    /**
     * @ORM\ManyToOne(targetEntity="VocHandlePosition", inversedBy="pottery", cascade={"persist"})      
     * @ORM\JoinColumn(nullable=true, referencedColumnName="id", onDelete="SET NULL")
     * @GRID\Column(field="handleposition.name", title="Handle Position", filter="select")
     */
    protected $handleposition;
    
    /**
     * @ORM\ManyToOne(targetEntity="VocSpout", inversedBy="pottery", cascade={"persist"})      
     * @ORM\JoinColumn(nullable=true, referencedColumnName="id", onDelete="SET NULL")
     * @GRID\Column(field="spout.name", title="Spout", filter="select")
     */
    protected $spout;
    
    /**
     * @ORM\ManyToOne(targetEntity="VocSpoutPosition", inversedBy="pottery", cascade={"persist"})      
     * @ORM\JoinColumn(nullable=true, referencedColumnName="id", onDelete="SET NULL")
     * @GRID\Column(field="spoutposition.name", title="Spout Position", filter="select")
     */
    protected $spoutposition;
    
    /**
     * @ORM\ManyToOne(targetEntity="VocPreservation", inversedBy="pottery", cascade={"persist"})      
     * @ORM\JoinColumn(nullable=true, referencedColumnName="id", onDelete="SET NULL")
     * @GRID\Column(field="preservation.name", title="Preservation", filter="select")
     */
    protected $preservation;
    
    /**
     * @ORM\ManyToOne(targetEntity="VocTechnique", inversedBy="pottery", cascade={"persist"})      
     * @ORM\JoinColumn(nullable=true, referencedColumnName="id", onDelete="SET NULL")
     * @GRID\Column(field="technique.name", title="Technique", filter="select")
     */
    protected $technique;
    
    /**
     * @ORM\ManyToOne(targetEntity="VocFiring", inversedBy="pottery", cascade={"persist"})      
     * @ORM\JoinColumn(nullable=true, referencedColumnName="id", onDelete="SET NULL")
     * @GRID\Column(field="firing.name", title="Firing", filter="select")
     */
    protected $firing;
    
    /**
     * @Gedmo\Versioned
     * @ORM\Column(nullable=true,length=64, type="string")
     */
    private $outercolor;
    /**
     * @Gedmo\Versioned
     * @ORM\Column(nullable=true,length=64, type="string")
     */
    private $innercolor;
    /**
     * @Gedmo\Versioned
     * @ORM\Column(nullable=true,length=64, type="string")
     */
    private $fabriccolor;
            
    /**
     * @ORM\ManyToOne(targetEntity="VocInclusion", inversedBy="pottery", cascade={"persist"})      
     * @ORM\JoinColumn(nullable=true, referencedColumnName="id")
     * @GRID\Column(field="inclusion.name", title="Inclusion", filter="select", type="text")
     */
    protected $inclusion;
    
    /**
     * @ORM\ManyToOne(targetEntity="VocInclusionSize", inversedBy="pottery", cascade={"persist"})      
     * @ORM\JoinColumn(nullable=true, referencedColumnName="id")
     * @GRID\Column(field="inclusionsize.name", title="Inclusion Size", type="text") 
     */
    protected $inclusionsize;
    
    /**
     * @ORM\ManyToOne(targetEntity="VocInclusionFrequency", inversedBy="pottery", cascade={"persist"})      
     * @ORM\JoinColumn(nullable=true, referencedColumnName="id")
     * @GRID\Column(field="inclusionfrequency.name", title="Inclusion Frequency")
     */
    protected $inclusionfrequency;
      
    /**
     * @ORM\OneToMany(targetEntity="VocPotterySurfacetratin", mappedBy="pottery", cascade={"persist"}, orphanRemoval=true) 
     * @GRID\Column(field="surfacetratin", title="Surface Treatment In")
     * @GRID\Column(field="surfacetratin.color.name", title="Color")
     */
    private $surfacetratin;
    
    /**
     * @ORM\OneToMany(targetEntity="VocPotterySurfacetratout", mappedBy="pottery", cascade={"persist"}, orphanRemoval=true) 
     * @GRID\Column(field="surfacetratout.name", title="Surface Treatament Out", filter="select")
     */
    private $surfacetratout;
    
    /**
     * @ORM\OneToMany(targetEntity="VocPotterySurfacetratinout", mappedBy="pottery", cascade={"persist"}, orphanRemoval=true) 
     * @GRID\Column(field="surfacetratinout.name", title="Surface Tratment In and Out", filter="select")
     */
    private $surfacetratinout;
    
    /**
     * @ORM\OneToMany(targetEntity="VocPotteryDecorationin", mappedBy="pottery", cascade={"persist"}, orphanRemoval=true) 
     * @GRID\Column(field="decorationin.name", title="Decoration In", filter="select")
     */
    private $potdecorationin;
    
    /**
     * @ORM\OneToMany(targetEntity="VocPotteryDecorationout", mappedBy="pottery", cascade={"persist"}, orphanRemoval=true) 
     * @GRID\Column(field="decorationout.name", title="Decoration Out", filter="select")
     */
    private $potdecorationout;
    
    /**
     * @ORM\OneToMany(targetEntity="VocPotteryDecorationinout", mappedBy="pottery", cascade={"persist"}, orphanRemoval=true) 
     * @GRID\Column(field="decorationinout.name", title="Decoration In and Out", filter="select")
     */
    private $potdecorationinout;
    
    /**
     * @Gedmo\Versioned
     * @ORM\Column(nullable=true,length=64, type="string")
     */
    private $rimdiameter;
    /**
     * @Gedmo\Versioned
     * @ORM\Column(nullable=true,length=64, type="string")
     */
    private $rimwidth;
    /**
     * @Gedmo\Versioned
     * @ORM\Column(nullable=true,length=64, type="string")
     */
    private $wallwidth;
    /**
     * @Gedmo\Versioned
     * @ORM\Column(nullable=true,length=64, type="string")
     */
    private $maxwalldiameter;
    /**
     * @Gedmo\Versioned
     * @ORM\Column(nullable=true,length=64, type="string")
     */
    private $bottomwidth;
    /**
     * @Gedmo\Versioned
     * @ORM\Column(nullable=true,length=64, type="string")
     */
    private $height;
    /**
     * @Gedmo\Versioned
     * @ORM\Column(nullable=true,length=64, type="string")
     */
    private $basediameter;
    
    /**
     * @Gedmo\Versioned
     * @ORM\Column(nullable=true,length=64, type="string")
     */
    private $restored;
    
    /**
     * @Gedmo\Versioned
     * @ORM\Column(nullable=true,length=64, type="string")
     * @GRID\Column(size="40", title="Date")
     */
    private $datation;
    
    public function __tostring() 
    {
        return $this->getTcode();
    }
    
    /**
     * Add surfacetratin
     *
     * @param Kdig\ArchaelogicalBundle\Entity\VocPotterySurfacetratin $surfacetratin
     */
    public function addVocPotterySurfacetratin(\Kdig\ArchaelogicalBundle\Entity\VocPotterySurfacetratin $surfacetratin)
    {
        $this->surfacetratin[] = $surfacetratin;
    }

    /**
     * Get surfacetratin
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getSurfacetratin()
    {
        return $this->surfacetratin;
    }

    /**
     * Add surfacetratout
     *
     * @param Kdig\ArchaelogicalBundle\Entity\VocPotterySurfacetratout $surfacetratout
     */
    public function addVocPotterySurfacetratout(\Kdig\ArchaelogicalBundle\Entity\VocPotterySurfacetratout $surfacetratout)
    {
        $this->surfacetratout[] = $surfacetratout;
    }

    /**
     * Get surfacetratout
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getSurfacetratout()
    {
        return $this->surfacetratout;
    }

    /**
     * Add surfacetratinout
     *
     * @param Kdig\ArchaelogicalBundle\Entity\VocPotterySurfacetratinout $surfacetratinout
     */
    public function addVocPotterySurfacetratinout(\Kdig\ArchaelogicalBundle\Entity\VocPotterySurfacetratinout $surfacetratinout)
    {
        $this->surfacetratinout[] = $surfacetratinout;
    }

    /**
     * Get surfacetratinout
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getSurfacetratinout()
    {
        return $this->surfacetratinout;
    }

    /**
     * Add potdecorationin
     *
     * @param Kdig\ArchaelogicalBundle\Entity\VocPotteryDecorationin $potdecorationin
     */
    public function addVocPotteryDecorationin(\Kdig\ArchaelogicalBundle\Entity\VocPotteryDecorationin $potdecorationin)
    {
        $this->potdecorationin[] = $potdecorationin;
    }

    /**
     * Add decorationinout
     *
     * @param Kdig\ArchaelogicalBundle\Entity\VocPotteryDecorationinout $potdecorationinout
     */
    public function addVocPotteryDecorationinout(\Kdig\ArchaelogicalBundle\Entity\VocPotteryDecorationinout $potdecorationinout)
    {
        $this->potdecorationinout[] = $potdecorationinout;
    }

    
    public function setPotdecorationout($relations)
    {
        foreach ($relations as $relation) {
            $relation->setPottery($this);
        }
        $this->potdecorationout = $relations;
    }
    public function setPotdecorationinout($relations)
    {
        foreach ($relations as $relation) {
            $relation->setPottery($this);
        }
        $this->potdecorationinout = $relations;
    }
    public function setPotdecorationin($relations)
    {
        foreach ($relations as $relation) {
            $relation->setPottery($this);
        }
        $this->potdecorationin = $relations;
    }
    public function setSurfacetratin($relations)
    {
        foreach ($relations as $relation) {
            $relation->setPottery($this);
        }
        $this->surfacetratin = $relations;
    }
    public function setSurfacetratout($relations)
    {
        foreach ($relations as $relation) {
            $relation->setPottery($this);
        }
        $this->surfacetratout = $relations;
    }
    public function setSurfacetratinout($relations)
    {
        foreach ($relations as $relation) {
            $relation->setPottery($this);
        }
        $this->surfacetratinout = $relations;
    }

    public function __construct()
    {
        $this->media = new \Doctrine\Common\Collections\ArrayCollection();
    $this->surfacetratin = new \Doctrine\Common\Collections\ArrayCollection();
    $this->surfacetratout = new \Doctrine\Common\Collections\ArrayCollection();
    $this->surfacetratinout = new \Doctrine\Common\Collections\ArrayCollection();
    $this->potdecorationin = new \Doctrine\Common\Collections\ArrayCollection();
    $this->potdecorationout = new \Doctrine\Common\Collections\ArrayCollection();
    $this->potdecorationinout = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set tcode
     *
     * @param string $tcode
     */
    public function setTcode($tcode)
    {
        $this->tcode = $tcode;
    }

    /**
     * Get tcode
     *
     * @return string 
     */
    public function getTcode()
    {
        return $this->tcode;
    }

    /**
     * Set typecontext
     *
     * @param integer $typecontext
     */
    public function setTypecontext($typecontext)
    {
        $this->typecontext = $typecontext;
    }

    /**
     * Get typecontext
     *
     * @return integer 
     */
    public function getTypecontext()
    {
        return $this->typecontext;
    }

    /**
     * Set outercolor
     *
     * @param string $outercolor
     */
    public function setOutercolor($outercolor)
    {
        $this->outercolor = $outercolor;
    }

    /**
     * Get outercolor
     *
     * @return string 
     */
    public function getOutercolor()
    {
        return $this->outercolor;
    }

    /**
     * Set innercolor
     *
     * @param string $innercolor
     */
    public function setInnercolor($innercolor)
    {
        $this->innercolor = $innercolor;
    }

    /**
     * Get innercolor
     *
     * @return string 
     */
    public function getInnercolor()
    {
        return $this->innercolor;
    }

    /**
     * Set fabriccolor
     *
     * @param string $fabriccolor
     */
    public function setFabriccolor($fabriccolor)
    {
        $this->fabriccolor = $fabriccolor;
    }

    /**
     * Get fabriccolor
     *
     * @return string 
     */
    public function getFabriccolor()
    {
        return $this->fabriccolor;
    }

    /**
     * Set rimdiameter
     *
     * @param string $rimdiameter
     */
    public function setRimdiameter($rimdiameter)
    {
        $this->rimdiameter = $rimdiameter;
    }

    /**
     * Get rimdiameter
     *
     * @return string 
     */
    public function getRimdiameter()
    {
        return $this->rimdiameter;
    }

    /**
     * Set rimwidth
     *
     * @param string $rimwidth
     */
    public function setRimwidth($rimwidth)
    {
        $this->rimwidth = $rimwidth;
    }

    /**
     * Get rimwidth
     *
     * @return string 
     */
    public function getRimwidth()
    {
        return $this->rimwidth;
    }

    /**
     * Set wallwidth
     *
     * @param string $wallwidth
     */
    public function setWallwidth($wallwidth)
    {
        $this->wallwidth = $wallwidth;
    }

    /**
     * Get wallwidth
     *
     * @return string 
     */
    public function getWallwidth()
    {
        return $this->wallwidth;
    }

    /**
     * Set maxwalldiameter
     *
     * @param string $maxwalldiameter
     */
    public function setMaxwalldiameter($maxwalldiameter)
    {
        $this->maxwalldiameter = $maxwalldiameter;
    }

    /**
     * Get maxwalldiameter
     *
     * @return string 
     */
    public function getMaxwalldiameter()
    {
        return $this->maxwalldiameter;
    }

    /**
     * Set bottomwidth
     *
     * @param string $bottomwidth
     */
    public function setBottomwidth($bottomwidth)
    {
        $this->bottomwidth = $bottomwidth;
    }

    /**
     * Get bottomwidth
     *
     * @return string 
     */
    public function getBottomwidth()
    {
        return $this->bottomwidth;
    }

    /**
     * Set height
     *
     * @param string $height
     */
    public function setHeight($height)
    {
        $this->height = $height;
    }

    /**
     * Get height
     *
     * @return string 
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Set basediameter
     *
     * @param string $basediameter
     */
    public function setBasediameter($basediameter)
    {
        $this->basediameter = $basediameter;
    }

    /**
     * Get basediameter
     *
     * @return string 
     */
    public function getBasediameter()
    {
        return $this->basediameter;
    }

    /**
     * Set restored
     *
     * @param string $restored
     */
    public function setRestored($restored)
    {
        $this->restored = $restored;
    }

    /**
     * Get restored
     *
     * @return string 
     */
    public function getRestored()
    {
        return $this->restored;
    }

    /**
     * Set prepottery
     *
     * @param Kdig\ArchaelogicalBundle\Entity\Prepottery $prepottery
     */
    public function setPrepottery(\Kdig\ArchaelogicalBundle\Entity\Prepottery $prepottery)
    {
        $this->prepottery = $prepottery;
    }

    /**
     * Get prepottery
     *
     * @return Kdig\ArchaelogicalBundle\Entity\Prepottery 
     */
    public function getPrepottery()
    {
        return $this->prepottery;
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
     * Set class
     *
     * @param Kdig\ArchaelogicalBundle\Entity\VocClass $class
     */
    public function setClass(\Kdig\ArchaelogicalBundle\Entity\VocClass $class)
    {
        $this->class = $class;
    }

    /**
     * Get class
     *
     * @return Kdig\ArchaelogicalBundle\Entity\VocClass 
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * Set shape
     *
     * @param Kdig\ArchaelogicalBundle\Entity\VocShape $shape
     */
    public function setShape(\Kdig\ArchaelogicalBundle\Entity\VocShape $shape)
    {
        $this->shape = $shape;
    }

    /**
     * Get shape
     *
     * @return Kdig\ArchaelogicalBundle\Entity\VocShape 
     */
    public function getShape()
    {
        return $this->shape;
    }

    /**
     * Set rim
     *
     * @param Kdig\ArchaelogicalBundle\Entity\VocRim $rim
     */
    public function setRim(\Kdig\ArchaelogicalBundle\Entity\VocRim $rim)
    {
        $this->rim = $rim;
    }

    /**
     * Get rim
     *
     * @return Kdig\ArchaelogicalBundle\Entity\VocRim 
     */
    public function getRim()
    {
        return $this->rim;
    }

    /**
     * Set neck
     *
     * @param Kdig\ArchaelogicalBundle\Entity\VocNeck $neck
     */
    public function setNeck(\Kdig\ArchaelogicalBundle\Entity\VocNeck $neck)
    {
        $this->neck = $neck;
    }

    /**
     * Get neck
     *
     * @return Kdig\ArchaelogicalBundle\Entity\VocNeck 
     */
    public function getNeck()
    {
        return $this->neck;
    }

    /**
     * Set wall
     *
     * @param Kdig\ArchaelogicalBundle\Entity\VocWall $wall
     */
    public function setWall(\Kdig\ArchaelogicalBundle\Entity\VocWall $wall)
    {
        $this->wall = $wall;
    }

    /**
     * Get wall
     *
     * @return Kdig\ArchaelogicalBundle\Entity\VocWall 
     */
    public function getWall()
    {
        return $this->wall;
    }

    /**
     * Set upperwall
     *
     * @param Kdig\ArchaelogicalBundle\Entity\VocUpperWall $upperwall
     */
    public function setUpperwall(\Kdig\ArchaelogicalBundle\Entity\VocUpperWall $upperwall)
    {
        $this->upperwall = $upperwall;
    }

    /**
     * Get upperwall
     *
     * @return Kdig\ArchaelogicalBundle\Entity\VocUpperWall 
     */
    public function getUpperwall()
    {
        return $this->upperwall;
    }

    /**
     * Set lowerwall
     *
     * @param Kdig\ArchaelogicalBundle\Entity\VocLowerWall $lowerwall
     */
    public function setLowerwall(\Kdig\ArchaelogicalBundle\Entity\VocLowerWall $lowerwall)
    {
        $this->lowerwall = $lowerwall;
    }

    /**
     * Get lowerwall
     *
     * @return Kdig\ArchaelogicalBundle\Entity\VocLowerWall 
     */
    public function getLowerwall()
    {
        return $this->lowerwall;
    }

    /**
     * Set base
     *
     * @param Kdig\ArchaelogicalBundle\Entity\VocBase $base
     */
    public function setBase(\Kdig\ArchaelogicalBundle\Entity\VocBase $base)
    {
        $this->base = $base;
    }

    /**
     * Get base
     *
     * @return Kdig\ArchaelogicalBundle\Entity\VocBase 
     */
    public function getBase()
    {
        return $this->base;
    }

    /**
     * Set handle
     *
     * @param Kdig\ArchaelogicalBundle\Entity\VocHandle $handle
     */
    public function setHandle(\Kdig\ArchaelogicalBundle\Entity\VocHandle $handle)
    {
        $this->handle = $handle;
    }

    /**
     * Get handle
     *
     * @return Kdig\ArchaelogicalBundle\Entity\VocHandle 
     */
    public function getHandle()
    {
        return $this->handle;
    }

    /**
     * Set handleposition
     *
     * @param Kdig\ArchaelogicalBundle\Entity\VocHandlePosition $handleposition
     */
    public function setHandleposition(\Kdig\ArchaelogicalBundle\Entity\VocHandlePosition $handleposition)
    {
        $this->handleposition = $handleposition;
    }

    /**
     * Get handleposition
     *
     * @return Kdig\ArchaelogicalBundle\Entity\VocHandlePosition 
     */
    public function getHandleposition()
    {
        return $this->handleposition;
    }

    /**
     * Set spout
     *
     * @param Kdig\ArchaelogicalBundle\Entity\VocSpout $spout
     */
    public function setSpout(\Kdig\ArchaelogicalBundle\Entity\VocSpout $spout)
    {
        $this->spout = $spout;
    }

    /**
     * Get spout
     *
     * @return Kdig\ArchaelogicalBundle\Entity\VocSpout 
     */
    public function getSpout()
    {
        return $this->spout;
    }

    /**
     * Set spoutposition
     *
     * @param Kdig\ArchaelogicalBundle\Entity\VocSpoutPosition $spoutposition
     */
    public function setSpoutposition(\Kdig\ArchaelogicalBundle\Entity\VocSpoutPosition $spoutposition)
    {
        $this->spoutposition = $spoutposition;
    }

    /**
     * Get spoutposition
     *
     * @return Kdig\ArchaelogicalBundle\Entity\VocSpoutPosition 
     */
    public function getSpoutposition()
    {
        return $this->spoutposition;
    }

    /**
     * Set preservation
     *
     * @param Kdig\ArchaelogicalBundle\Entity\VocPreservation $preservation
     */
    public function setPreservation(\Kdig\ArchaelogicalBundle\Entity\VocPreservation $preservation)
    {
        $this->preservation = $preservation;
    }

    /**
     * Get preservation
     *
     * @return Kdig\ArchaelogicalBundle\Entity\VocPreservation 
     */
    public function getPreservation()
    {
        return $this->preservation;
    }

    /**
     * Set technique
     *
     * @param Kdig\ArchaelogicalBundle\Entity\VocTechnique $technique
     */
    public function setTechnique(\Kdig\ArchaelogicalBundle\Entity\VocTechnique $technique)
    {
        $this->technique = $technique;
    }

    /**
     * Get technique
     *
     * @return Kdig\ArchaelogicalBundle\Entity\VocTechnique 
     */
    public function getTechnique()
    {
        return $this->technique;
    }

    /**
     * Set firing
     *
     * @param Kdig\ArchaelogicalBundle\Entity\VocFiring $firing
     */
    public function setFiring(\Kdig\ArchaelogicalBundle\Entity\VocFiring $firing)
    {
        $this->firing = $firing;
    }

    /**
     * Get firing
     *
     * @return Kdig\ArchaelogicalBundle\Entity\VocFiring 
     */
    public function getFiring()
    {
        return $this->firing;
    }

    /**
     * Set inclusion
     *
     * @param Kdig\ArchaelogicalBundle\Entity\VocInclusion $inclusion
     */
    public function setInclusion(\Kdig\ArchaelogicalBundle\Entity\VocInclusion $inclusion)
    {
        $this->inclusion = $inclusion;
    }

    /**
     * Get inclusion
     *
     * @return Kdig\ArchaelogicalBundle\Entity\VocInclusion 
     */
    public function getInclusion()
    {
        return $this->inclusion;
    }

    /**
     * Set inclusionsize
     *
     * @param Kdig\ArchaelogicalBundle\Entity\VocInclusionSize $inclusionsize
     */
    public function setInclusionsize(\Kdig\ArchaelogicalBundle\Entity\VocInclusionSize $inclusionsize)
    {
        $this->inclusionsize = $inclusionsize;
    }

    /**
     * Get inclusionsize
     *
     * @return Kdig\ArchaelogicalBundle\Entity\VocInclusionSize 
     */
    public function getInclusionsize()
    {
        return $this->inclusionsize;
    }

    /**
     * Set inclusionfrequency
     *
     * @param Kdig\ArchaelogicalBundle\Entity\VocInclusionFrequency $inclusionfrequency
     */
    public function setInclusionfrequency(\Kdig\ArchaelogicalBundle\Entity\VocInclusionFrequency $inclusionfrequency)
    {
        $this->inclusionfrequency = $inclusionfrequency;
    }

    /**
     * Get inclusionfrequency
     *
     * @return Kdig\ArchaelogicalBundle\Entity\VocInclusionFrequency 
     */
    public function getInclusionfrequency()
    {
        return $this->inclusionfrequency;
    }

    /**
     * Get potdecorationin
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getPotdecorationin()
    {
        return $this->potdecorationin;
    }

    /**
     * Add potdecorationout
     *
     * @param Kdig\ArchaelogicalBundle\Entity\VocPotteryDecorationout $potdecorationout
     */
    public function addVocPotteryDecorationout(\Kdig\ArchaelogicalBundle\Entity\VocPotteryDecorationout $potdecorationout)
    {
        $this->potdecorationout[] = $potdecorationout;
    }

    /**
     * Get potdecorationout
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getPotdecorationout()
    {
        return $this->potdecorationout;
    }

    /**
     * Get potdecorationinout
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getPotdecorationinout()
    {
        return $this->potdecorationinout;
    }

    /**
     * Set datation
     *
     * @param string $datation
     */
    public function setDatation($datation)
    {
        $this->datation = $datation;
    }

    /**
     * Get datation
     *
     * @return string 
     */
    public function getDatation()
    {
        return $this->datation;
    }
}