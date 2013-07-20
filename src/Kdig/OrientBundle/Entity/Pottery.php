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

use Kdig\OrientBundle\Entity\BaseEntity;

use Symfony\Component\Validator\Constraints as Assert;
use APY\DataGridBundle\Grid\Mapping as GRID;

use Sonata\AdminBundle\Admin\Admin;
use Symfony\Component\HttpKernel\Kernel;

/**
 * @ORM\Entity
 * @ORM\Table(name="pottery", schema="public")
 * @Gedmo\Loggable
 * @ORM\HasLifecycleCallbacks
 * @GRID\Source(columns="id,surfacetratin.color.name,prepottery.bucket.us.site.campagna, prepottery.bucket.us.area.name, typecontext, prepottery.bucket.us.typeus.name, prepottery.bucket.us.name, prepottery.bucket.name, prepottery.name, class.name, shape.name, rim.name, neck.name, wall.name, upperwall.name, lowerwall.name, base.name, handle.name, handleposition.name, spout.name, spoutposition.name, preservation.name, technique.name, firing.name, outercolor, innercolor, fabriccolor, inclusion.name, inclusionsize.name, inclusionfrequency.name, rimdiameter, rimwidth, wallwidth,  maxwalldiameter, bottomwidth, height, basediameter,datation,restored, remarks, created, tcode")
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
     * @ORM\OneToOne(targetEntity="Kdig\ArchaeologicalBundle\Entity\Prepottery", inversedBy="pottery", orphanRemoval=true)
     * @GRID\Column(field="prepottery.name", title="Field", size="40")
     * @GRID\Column(field="prepottery.bucket.us.name", title="Locus", filter="select", size="40")
     * @GRID\Column(field="prepottery.bucket.us.typeus.name", title="Type Locus", filter="select", size="40")
     * @GRID\Column(field="prepottery.bucket.name", title="Bucket", filter="select", size="40")
     * @GRID\Column(field="prepottery.bucket.us.area.name",title="Area", filter="select", size="20")
     * @GRID\Column(field="prepottery.bucket.us.site.campagna",title="Campaign", filter="select", size="20")
     */
    private $prepottery;
    
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
     * @ORM\ManyToOne(targetEntity="Kdig\OrientBundle\Entity\Potteryvoc\VocClass", inversedBy="pottery", cascade={"persist"})      
     * @ORM\JoinColumn(nullable=true, referencedColumnName="id", onDelete="SET NULL")
     * @GRID\Column(field="class.name", title="Class", filter="select")
     */
    protected $class;
    
    /**
     * @ORM\ManyToOne(targetEntity="Kdig\OrientBundle\Entity\Potteryvoc\VocShape", inversedBy="pottery", cascade={"persist"})      
     * @ORM\JoinColumn(nullable=true, referencedColumnName="id", onDelete="SET NULL")
     * @GRID\Column(field="shape.name", title="Shape", filter="select")
     */
    protected $shape;
    
    /**
     * @ORM\ManyToOne(targetEntity="Kdig\OrientBundle\Entity\Potteryvoc\VocRim", inversedBy="pottery", cascade={"persist"})      
     * @ORM\JoinColumn(nullable=true, referencedColumnName="id", onDelete="SET NULL")
     * @GRID\Column(field="rim.name", title="Rim", filter="select")
     */
    protected $rim;
    
    /**
     * @ORM\ManyToOne(targetEntity="Kdig\OrientBundle\Entity\Potteryvoc\VocNeck", inversedBy="pottery", cascade={"persist"})      
     * @ORM\JoinColumn(nullable=true, referencedColumnName="id", onDelete="SET NULL")
     * @GRID\Column(field="neck.name", title="Neck", filter="select")
     */
    protected $neck;
    
    /**
     * @ORM\ManyToOne(targetEntity="Kdig\OrientBundle\Entity\Potteryvoc\VocWall", inversedBy="pottery", cascade={"persist"})      
     * @ORM\JoinColumn(nullable=true, referencedColumnName="id", onDelete="SET NULL")
     * @GRID\Column(field="wall.name", title="Wall", filter="select")
     */
    protected $wall;
    
    /**
     * @ORM\ManyToOne(targetEntity="Kdig\OrientBundle\Entity\Potteryvoc\VocUpperWall", inversedBy="pottery", cascade={"persist"})      
     * @ORM\JoinColumn(nullable=true, referencedColumnName="id", onDelete="SET NULL")
     * @GRID\Column(field="upperwall.name", title="Upper Wall", filter="select")
     */
    protected $upperwall;
    
    /**
     * @ORM\ManyToOne(targetEntity="Kdig\OrientBundle\Entity\Potteryvoc\VocLowerWall", inversedBy="pottery", cascade={"persist"})      
     * @ORM\JoinColumn(nullable=true, referencedColumnName="id", onDelete="SET NULL")
     * @GRID\Column(field="lowerwall.name", title="Lower Wall", filter="select")
     */
    protected $lowerwall;
    
    /**
     * @ORM\ManyToOne(targetEntity="Kdig\OrientBundle\Entity\Potteryvoc\VocBase", inversedBy="pottery", cascade={"persist"})      
     * @ORM\JoinColumn(nullable=true, referencedColumnName="id", onDelete="SET NULL")
     * @GRID\Column(field="base.name", title="Base", filter="select")
     */
    protected $base;
    
    /**
     * @ORM\ManyToOne(targetEntity="Kdig\OrientBundle\Entity\Potteryvoc\VocHandle", inversedBy="pottery", cascade={"persist"})      
     * @ORM\JoinColumn(nullable=true, referencedColumnName="id", onDelete="SET NULL")
     * @GRID\Column(field="handle.name", title="Handle", filter="select")
     */
    protected $handle;
    
    /**
     * @ORM\ManyToOne(targetEntity="Kdig\OrientBundle\Entity\Potteryvoc\VocHandlePosition", inversedBy="pottery", cascade={"persist"})      
     * @ORM\JoinColumn(nullable=true, referencedColumnName="id", onDelete="SET NULL")
     * @GRID\Column(field="handleposition.name", title="Handle Position", filter="select")
     */
    protected $handleposition;
    
    /**
     * @ORM\ManyToOne(targetEntity="Kdig\OrientBundle\Entity\Potteryvoc\VocSpout", inversedBy="pottery", cascade={"persist"})      
     * @ORM\JoinColumn(nullable=true, referencedColumnName="id", onDelete="SET NULL")
     * @GRID\Column(field="spout.name", title="Spout", filter="select")
     */
    protected $spout;
    
    /**
     * @ORM\ManyToOne(targetEntity="Kdig\OrientBundle\Entity\Potteryvoc\VocSpoutPosition", inversedBy="pottery", cascade={"persist"})      
     * @ORM\JoinColumn(nullable=true, referencedColumnName="id", onDelete="SET NULL")
     * @GRID\Column(field="spoutposition.name", title="Spout Position", filter="select")
     */
    protected $spoutposition;
    
    /**
     * @ORM\ManyToOne(targetEntity="Kdig\OrientBundle\Entity\Potteryvoc\VocPreservation", inversedBy="pottery", cascade={"persist"})      
     * @ORM\JoinColumn(nullable=true, referencedColumnName="id", onDelete="SET NULL")
     * @GRID\Column(field="preservation.name", title="Preservation", filter="select")
     */
    protected $preservation;
    
    /**
     * @ORM\ManyToOne(targetEntity="Kdig\OrientBundle\Entity\Potteryvoc\VocTechnique", inversedBy="pottery", cascade={"persist"})      
     * @ORM\JoinColumn(nullable=true, referencedColumnName="id", onDelete="SET NULL")
     * @GRID\Column(field="technique.name", title="Technique", filter="select")
     */
    protected $technique;
    
    /**
     * @ORM\ManyToOne(targetEntity="Kdig\OrientBundle\Entity\Potteryvoc\VocFiring", inversedBy="pottery", cascade={"persist"})      
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
     * @ORM\ManyToOne(targetEntity="Kdig\OrientBundle\Entity\Potteryvoc\VocInclusion", inversedBy="pottery", cascade={"persist"})      
     * @ORM\JoinColumn(nullable=true, referencedColumnName="id")
     * @GRID\Column(field="inclusion.name", title="Inclusion", filter="select", type="text")
     */
    protected $inclusion;
    
    /**
     * @ORM\ManyToOne(targetEntity="Kdig\OrientBundle\Entity\Potteryvoc\VocInclusionSize", inversedBy="pottery", cascade={"persist"})      
     * @ORM\JoinColumn(nullable=true, referencedColumnName="id")
     * @GRID\Column(field="inclusionsize.name", title="Inclusion Size", type="text") 
     */
    protected $inclusionsize;
    
    /**
     * @ORM\ManyToOne(targetEntity="Kdig\OrientBundle\Entity\Potteryvoc\VocInclusionFrequency", inversedBy="pottery", cascade={"persist"})      
     * @ORM\JoinColumn(nullable=true, referencedColumnName="id")
     * @GRID\Column(field="inclusionfrequency.name", title="Inclusion Frequency")
     */
    protected $inclusionfrequency;
      
    /**
     * @ORM\OneToMany(targetEntity="Kdig\OrientBundle\Entity\Potteryvoc\VocPotterySurfacetratin", mappedBy="pottery", orphanRemoval=true) 
     * @GRID\Column(field="surfacetratin", title="Surface Treatment In")
     * @GRID\Column(field="surfacetratin.color.name", title="Color", type="array")
     */
    private $surfacetratin;
    
    /**
     * @ORM\OneToMany(targetEntity="Kdig\OrientBundle\Entity\Potteryvoc\VocPotterySurfacetratout", mappedBy="pottery", orphanRemoval=true) 
     * @GRID\Column(field="surfacetratout.color.name", title="Surface Treatament Out", type="array")
     */
    private $surfacetratout;
    
    /**
     * @ORM\OneToMany(targetEntity="Kdig\OrientBundle\Entity\Potteryvoc\VocPotterySurfacetratinout", mappedBy="pottery", orphanRemoval=true) 
     * @GRID\Column(field="surfacetratinout.name", title="Surface Tratment In and Out", filter="select")
     */
    private $surfacetratinout;
    
    /**
     * @ORM\OneToMany(targetEntity="Kdig\OrientBundle\Entity\Potteryvoc\VocPotteryDecorationin", mappedBy="pottery", orphanRemoval=true) 
     * @GRID\Column(field="decorationin.name", title="Decoration In", filter="select")
     */
    private $potdecorationin;
    
    /**
     * @ORM\OneToMany(targetEntity="Kdig\OrientBundle\Entity\Potteryvoc\VocPotteryDecorationout", mappedBy="pottery", orphanRemoval=true) 
     * @GRID\Column(field="decorationout.name", title="Decoration Out", filter="select")
     */
    private $potdecorationout;
    
    /**
     * @ORM\OneToMany(targetEntity="Kdig\OrientBundle\Entity\Potteryvoc\VocPotteryDecorationinout", mappedBy="pottery", orphanRemoval=true) 
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
    /**
     * Constructor
     */
    public function __construct()
    {
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
     * @param string $remarks
     * @return Pottery
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
     * @return Pottery
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
     * @return Pottery
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
     * @return Pottery
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
     * @return Pottery
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
     * @return Pottery
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
     * Set tcode
     *
     * @param string $tcode
     * @return Pottery
     */
    public function setTcode($tcode)
    {
        $this->tcode = $tcode;
    
        return $this;
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
     * @return Pottery
     */
    public function setTypecontext($typecontext)
    {
        $this->typecontext = $typecontext;
    
        return $this;
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
     * @return Pottery
     */
    public function setOutercolor($outercolor)
    {
        $this->outercolor = $outercolor;
    
        return $this;
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
     * @return Pottery
     */
    public function setInnercolor($innercolor)
    {
        $this->innercolor = $innercolor;
    
        return $this;
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
     * @return Pottery
     */
    public function setFabriccolor($fabriccolor)
    {
        $this->fabriccolor = $fabriccolor;
    
        return $this;
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
     * @return Pottery
     */
    public function setRimdiameter($rimdiameter)
    {
        $this->rimdiameter = $rimdiameter;
    
        return $this;
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
     * @return Pottery
     */
    public function setRimwidth($rimwidth)
    {
        $this->rimwidth = $rimwidth;
    
        return $this;
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
     * @return Pottery
     */
    public function setWallwidth($wallwidth)
    {
        $this->wallwidth = $wallwidth;
    
        return $this;
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
     * @return Pottery
     */
    public function setMaxwalldiameter($maxwalldiameter)
    {
        $this->maxwalldiameter = $maxwalldiameter;
    
        return $this;
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
     * @return Pottery
     */
    public function setBottomwidth($bottomwidth)
    {
        $this->bottomwidth = $bottomwidth;
    
        return $this;
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
     * @return Pottery
     */
    public function setHeight($height)
    {
        $this->height = $height;
    
        return $this;
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
     * @return Pottery
     */
    public function setBasediameter($basediameter)
    {
        $this->basediameter = $basediameter;
    
        return $this;
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
     * @return Pottery
     */
    public function setRestored($restored)
    {
        $this->restored = $restored;
    
        return $this;
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
     * Set datation
     *
     * @param string $datation
     * @return Pottery
     */
    public function setDatation($datation)
    {
        $this->datation = $datation;
    
        return $this;
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

    /**
     * Set prepottery
     *
     * @param \Kdig\ArchaeologicalBundle\Entity\Prepottery $prepottery
     * @return Pottery
     */
    public function setPrepottery(\Kdig\ArchaeologicalBundle\Entity\Prepottery $prepottery = null)
    {
        $this->prepottery = $prepottery;
    
        return $this;
    }

    /**
     * Get prepottery
     *
     * @return \Kdig\ArchaeologicalBundle\Entity\Prepottery 
     */
    public function getPrepottery()
    {
        return $this->prepottery;
    }

    /**
     * Set class
     *
     * @param \Kdig\OrientBundle\Entity\Potteryvoc\VocClass $class
     * @return Pottery
     */
    public function setClass(\Kdig\OrientBundle\Entity\Potteryvoc\VocClass $class = null)
    {
        $this->class = $class;
    
        return $this;
    }

    /**
     * Get class
     *
     * @return \Kdig\OrientBundle\Entity\Potteryvoc\VocClass 
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * Set shape
     *
     * @param \Kdig\OrientBundle\Entity\Potteryvoc\VocShape $shape
     * @return Pottery
     */
    public function setShape(\Kdig\OrientBundle\Entity\Potteryvoc\VocShape $shape = null)
    {
        $this->shape = $shape;
    
        return $this;
    }

    /**
     * Get shape
     *
     * @return \Kdig\OrientBundle\Entity\Potteryvoc\VocShape 
     */
    public function getShape()
    {
        return $this->shape;
    }

    /**
     * Set rim
     *
     * @param \Kdig\OrientBundle\Entity\Potteryvoc\VocRim $rim
     * @return Pottery
     */
    public function setRim(\Kdig\OrientBundle\Entity\Potteryvoc\VocRim $rim = null)
    {
        $this->rim = $rim;
    
        return $this;
    }

    /**
     * Get rim
     *
     * @return \Kdig\OrientBundle\Entity\Potteryvoc\VocRim 
     */
    public function getRim()
    {
        return $this->rim;
    }

    /**
     * Set neck
     *
     * @param \Kdig\OrientBundle\Entity\Potteryvoc\VocNeck $neck
     * @return Pottery
     */
    public function setNeck(\Kdig\OrientBundle\Entity\Potteryvoc\VocNeck $neck = null)
    {
        $this->neck = $neck;
    
        return $this;
    }

    /**
     * Get neck
     *
     * @return \Kdig\OrientBundle\Entity\Potteryvoc\VocNeck 
     */
    public function getNeck()
    {
        return $this->neck;
    }

    /**
     * Set wall
     *
     * @param \Kdig\OrientBundle\Entity\Potteryvoc\VocWall $wall
     * @return Pottery
     */
    public function setWall(\Kdig\OrientBundle\Entity\Potteryvoc\VocWall $wall = null)
    {
        $this->wall = $wall;
    
        return $this;
    }

    /**
     * Get wall
     *
     * @return \Kdig\OrientBundle\Entity\Potteryvoc\VocWall 
     */
    public function getWall()
    {
        return $this->wall;
    }

    /**
     * Set upperwall
     *
     * @param \Kdig\OrientBundle\Entity\Potteryvoc\VocUpperWall $upperwall
     * @return Pottery
     */
    public function setUpperwall(\Kdig\OrientBundle\Entity\Potteryvoc\VocUpperWall $upperwall = null)
    {
        $this->upperwall = $upperwall;
    
        return $this;
    }

    /**
     * Get upperwall
     *
     * @return \Kdig\OrientBundle\Entity\Potteryvoc\VocUpperWall 
     */
    public function getUpperwall()
    {
        return $this->upperwall;
    }

    /**
     * Set lowerwall
     *
     * @param \Kdig\OrientBundle\Entity\Potteryvoc\VocLowerWall $lowerwall
     * @return Pottery
     */
    public function setLowerwall(\Kdig\OrientBundle\Entity\Potteryvoc\VocLowerWall $lowerwall = null)
    {
        $this->lowerwall = $lowerwall;
    
        return $this;
    }

    /**
     * Get lowerwall
     *
     * @return \Kdig\OrientBundle\Entity\Potteryvoc\VocLowerWall 
     */
    public function getLowerwall()
    {
        return $this->lowerwall;
    }

    /**
     * Set base
     *
     * @param \Kdig\OrientBundle\Entity\Potteryvoc\VocBase $base
     * @return Pottery
     */
    public function setBase(\Kdig\OrientBundle\Entity\Potteryvoc\VocBase $base = null)
    {
        $this->base = $base;
    
        return $this;
    }

    /**
     * Get base
     *
     * @return \Kdig\OrientBundle\Entity\Potteryvoc\VocBase 
     */
    public function getBase()
    {
        return $this->base;
    }

    /**
     * Set handle
     *
     * @param \Kdig\OrientBundle\Entity\Potteryvoc\VocHandle $handle
     * @return Pottery
     */
    public function setHandle(\Kdig\OrientBundle\Entity\Potteryvoc\VocHandle $handle = null)
    {
        $this->handle = $handle;
    
        return $this;
    }

    /**
     * Get handle
     *
     * @return \Kdig\OrientBundle\Entity\Potteryvoc\VocHandle 
     */
    public function getHandle()
    {
        return $this->handle;
    }

    /**
     * Set handleposition
     *
     * @param \Kdig\OrientBundle\Entity\Potteryvoc\VocHandlePosition $handleposition
     * @return Pottery
     */
    public function setHandleposition(\Kdig\OrientBundle\Entity\Potteryvoc\VocHandlePosition $handleposition = null)
    {
        $this->handleposition = $handleposition;
    
        return $this;
    }

    /**
     * Get handleposition
     *
     * @return \Kdig\OrientBundle\Entity\Potteryvoc\VocHandlePosition 
     */
    public function getHandleposition()
    {
        return $this->handleposition;
    }

    /**
     * Set spout
     *
     * @param \Kdig\OrientBundle\Entity\Potteryvoc\VocSpout $spout
     * @return Pottery
     */
    public function setSpout(\Kdig\OrientBundle\Entity\Potteryvoc\VocSpout $spout = null)
    {
        $this->spout = $spout;
    
        return $this;
    }

    /**
     * Get spout
     *
     * @return \Kdig\OrientBundle\Entity\Potteryvoc\VocSpout 
     */
    public function getSpout()
    {
        return $this->spout;
    }

    /**
     * Set spoutposition
     *
     * @param \Kdig\OrientBundle\Entity\Potteryvoc\VocSpoutPosition $spoutposition
     * @return Pottery
     */
    public function setSpoutposition(\Kdig\OrientBundle\Entity\Potteryvoc\VocSpoutPosition $spoutposition = null)
    {
        $this->spoutposition = $spoutposition;
    
        return $this;
    }

    /**
     * Get spoutposition
     *
     * @return \Kdig\OrientBundle\Entity\Potteryvoc\VocSpoutPosition 
     */
    public function getSpoutposition()
    {
        return $this->spoutposition;
    }

    /**
     * Set preservation
     *
     * @param \Kdig\OrientBundle\Entity\Potteryvoc\VocPreservation $preservation
     * @return Pottery
     */
    public function setPreservation(\Kdig\OrientBundle\Entity\Potteryvoc\VocPreservation $preservation = null)
    {
        $this->preservation = $preservation;
    
        return $this;
    }

    /**
     * Get preservation
     *
     * @return \Kdig\OrientBundle\Entity\Potteryvoc\VocPreservation 
     */
    public function getPreservation()
    {
        return $this->preservation;
    }

    /**
     * Set technique
     *
     * @param \Kdig\OrientBundle\Entity\Potteryvoc\VocTechnique $technique
     * @return Pottery
     */
    public function setTechnique(\Kdig\OrientBundle\Entity\Potteryvoc\VocTechnique $technique = null)
    {
        $this->technique = $technique;
    
        return $this;
    }

    /**
     * Get technique
     *
     * @return \Kdig\OrientBundle\Entity\Potteryvoc\VocTechnique 
     */
    public function getTechnique()
    {
        return $this->technique;
    }

    /**
     * Set firing
     *
     * @param \Kdig\OrientBundle\Entity\Potteryvoc\VocFiring $firing
     * @return Pottery
     */
    public function setFiring(\Kdig\OrientBundle\Entity\Potteryvoc\VocFiring $firing = null)
    {
        $this->firing = $firing;
    
        return $this;
    }

    /**
     * Get firing
     *
     * @return \Kdig\OrientBundle\Entity\Potteryvoc\VocFiring 
     */
    public function getFiring()
    {
        return $this->firing;
    }

    /**
     * Set inclusion
     *
     * @param \Kdig\OrientBundle\Entity\Potteryvoc\VocInclusion $inclusion
     * @return Pottery
     */
    public function setInclusion(\Kdig\OrientBundle\Entity\Potteryvoc\VocInclusion $inclusion = null)
    {
        $this->inclusion = $inclusion;
    
        return $this;
    }

    /**
     * Get inclusion
     *
     * @return \Kdig\OrientBundle\Entity\Potteryvoc\VocInclusion 
     */
    public function getInclusion()
    {
        return $this->inclusion;
    }

    /**
     * Set inclusionsize
     *
     * @param \Kdig\OrientBundle\Entity\Potteryvoc\VocInclusionSize $inclusionsize
     * @return Pottery
     */
    public function setInclusionsize(\Kdig\OrientBundle\Entity\Potteryvoc\VocInclusionSize $inclusionsize = null)
    {
        $this->inclusionsize = $inclusionsize;
    
        return $this;
    }

    /**
     * Get inclusionsize
     *
     * @return \Kdig\OrientBundle\Entity\Potteryvoc\VocInclusionSize 
     */
    public function getInclusionsize()
    {
        return $this->inclusionsize;
    }

    /**
     * Set inclusionfrequency
     *
     * @param \Kdig\OrientBundle\Entity\Potteryvoc\VocInclusionFrequency $inclusionfrequency
     * @return Pottery
     */
    public function setInclusionfrequency(\Kdig\OrientBundle\Entity\Potteryvoc\VocInclusionFrequency $inclusionfrequency = null)
    {
        $this->inclusionfrequency = $inclusionfrequency;
    
        return $this;
    }

    /**
     * Get inclusionfrequency
     *
     * @return \Kdig\OrientBundle\Entity\Potteryvoc\VocInclusionFrequency 
     */
    public function getInclusionfrequency()
    {
        return $this->inclusionfrequency;
    }

    /**
     * Add surfacetratin
     *
     * @param \Kdig\OrientBundle\Entity\Potteryvoc\VocPotterySurfacetratin $surfacetratin
     * @return Pottery
     */
    public function addSurfacetratin(\Kdig\OrientBundle\Entity\Potteryvoc\VocPotterySurfacetratin $surfacetratin)
    {
        $this->surfacetratin[] = $surfacetratin;
    
        return $this;
    }

    /**
     * Remove surfacetratin
     *
     * @param \Kdig\OrientBundle\Entity\Potteryvoc\VocPotterySurfacetratin $surfacetratin
     */
    public function removeSurfacetratin(\Kdig\OrientBundle\Entity\Potteryvoc\VocPotterySurfacetratin $surfacetratin)
    {
        $this->surfacetratin->removeElement($surfacetratin);
    }

    /**
     * Get surfacetratin
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSurfacetratin()
    {
        return $this->surfacetratin;
    }

    /**
     * Add surfacetratout
     *
     * @param \Kdig\OrientBundle\Entity\Potteryvoc\VocPotterySurfacetratout $surfacetratout
     * @return Pottery
     */
    public function addSurfacetratout(\Kdig\OrientBundle\Entity\Potteryvoc\VocPotterySurfacetratout $surfacetratout)
    {
        $this->surfacetratout[] = $surfacetratout;
    
        return $this;
    }

    /**
     * Remove surfacetratout
     *
     * @param \Kdig\OrientBundle\Entity\Potteryvoc\VocPotterySurfacetratout $surfacetratout
     */
    public function removeSurfacetratout(\Kdig\OrientBundle\Entity\Potteryvoc\VocPotterySurfacetratout $surfacetratout)
    {
        $this->surfacetratout->removeElement($surfacetratout);
    }

    /**
     * Get surfacetratout
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSurfacetratout()
    {
        return $this->surfacetratout;
    }

    /**
     * Add surfacetratinout
     *
     * @param \Kdig\OrientBundle\Entity\Potteryvoc\VocPotterySurfacetratinout $surfacetratinout
     * @return Pottery
     */
    public function addSurfacetratinout(\Kdig\OrientBundle\Entity\Potteryvoc\VocPotterySurfacetratinout $surfacetratinout)
    {
        $this->surfacetratinout[] = $surfacetratinout;
    
        return $this;
    }

    /**
     * Remove surfacetratinout
     *
     * @param \Kdig\OrientBundle\Entity\Potteryvoc\VocPotterySurfacetratinout $surfacetratinout
     */
    public function removeSurfacetratinout(\Kdig\OrientBundle\Entity\Potteryvoc\VocPotterySurfacetratinout $surfacetratinout)
    {
        $this->surfacetratinout->removeElement($surfacetratinout);
    }

    /**
     * Get surfacetratinout
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSurfacetratinout()
    {
        return $this->surfacetratinout;
    }

    /**
     * Add potdecorationin
     *
     * @param \Kdig\OrientBundle\Entity\Potteryvoc\VocPotteryDecorationin $potdecorationin
     * @return Pottery
     */
    public function addPotdecorationin(\Kdig\OrientBundle\Entity\Potteryvoc\VocPotteryDecorationin $potdecorationin)
    {
        $this->potdecorationin[] = $potdecorationin;
    
        return $this;
    }

    /**
     * Remove potdecorationin
     *
     * @param \Kdig\OrientBundle\Entity\Potteryvoc\VocPotteryDecorationin $potdecorationin
     */
    public function removePotdecorationin(\Kdig\OrientBundle\Entity\Potteryvoc\VocPotteryDecorationin $potdecorationin)
    {
        $this->potdecorationin->removeElement($potdecorationin);
    }

    /**
     * Get potdecorationin
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPotdecorationin()
    {
        return $this->potdecorationin;
    }

    /**
     * Add potdecorationout
     *
     * @param \Kdig\OrientBundle\Entity\Potteryvoc\VocPotteryDecorationout $potdecorationout
     * @return Pottery
     */
    public function addPotdecorationout(\Kdig\OrientBundle\Entity\Potteryvoc\VocPotteryDecorationout $potdecorationout)
    {
        $this->potdecorationout[] = $potdecorationout;
    
        return $this;
    }

    /**
     * Remove potdecorationout
     *
     * @param \Kdig\OrientBundle\Entity\Potteryvoc\VocPotteryDecorationout $potdecorationout
     */
    public function removePotdecorationout(\Kdig\OrientBundle\Entity\Potteryvoc\VocPotteryDecorationout $potdecorationout)
    {
        $this->potdecorationout->removeElement($potdecorationout);
    }

    /**
     * Get potdecorationout
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPotdecorationout()
    {
        return $this->potdecorationout;
    }

    /**
     * Add potdecorationinout
     *
     * @param \Kdig\OrientBundle\Entity\Potteryvoc\VocPotteryDecorationinout $potdecorationinout
     * @return Pottery
     */
    public function addPotdecorationinout(\Kdig\OrientBundle\Entity\Potteryvoc\VocPotteryDecorationinout $potdecorationinout)
    {
        $this->potdecorationinout[] = $potdecorationinout;
    
        return $this;
    }

    /**
     * Remove potdecorationinout
     *
     * @param \Kdig\OrientBundle\Entity\Potteryvoc\VocPotteryDecorationinout $potdecorationinout
     */
    public function removePotdecorationinout(\Kdig\OrientBundle\Entity\Potteryvoc\VocPotteryDecorationinout $potdecorationinout)
    {
        $this->potdecorationinout->removeElement($potdecorationinout);
    }

    /**
     * Get potdecorationinout
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPotdecorationinout()
    {
        return $this->potdecorationinout;
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
    
    public function __tostring() 
    {
        return (string)$this->getPrepottery()->getName().' ('.$this->getTcode().')';
    }
}