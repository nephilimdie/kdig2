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
     * @ORM\OneToOne(targetEntity="Kdig\ArchaelogicalBundle\Entity\Prepottery", inversedBy="pottery", cascade={"persist"})
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
     * @ORM\OneToMany(targetEntity="Kdig\OrientBundle\Entity\Potteryvoc\VocPotterySurfacetratin", mappedBy="pottery", cascade={"persist"}, orphanRemoval=true) 
     * @GRID\Column(field="surfacetratin", title="Surface Treatment In")
     * @GRID\Column(field="surfacetratin.color.name", title="Color")
     */
    private $surfacetratin;
    
    /**
     * @ORM\OneToMany(targetEntity="Kdig\OrientBundle\Entity\Potteryvoc\VocPotterySurfacetratout", mappedBy="pottery", cascade={"persist"}, orphanRemoval=true) 
     * @GRID\Column(field="surfacetratout.name", title="Surface Treatament Out", filter="select")
     */
    private $surfacetratout;
    
    /**
     * @ORM\OneToMany(targetEntity="Kdig\OrientBundle\Entity\Potteryvoc\VocPotterySurfacetratinout", mappedBy="pottery", cascade={"persist"}, orphanRemoval=true) 
     * @GRID\Column(field="surfacetratinout.name", title="Surface Tratment In and Out", filter="select")
     */
    private $surfacetratinout;
    
    /**
     * @ORM\OneToMany(targetEntity="Kdig\OrientBundle\Entity\Potteryvoc\VocPotteryDecorationin", mappedBy="pottery", cascade={"persist"}, orphanRemoval=true) 
     * @GRID\Column(field="decorationin.name", title="Decoration In", filter="select")
     */
    private $potdecorationin;
    
    /**
     * @ORM\OneToMany(targetEntity="Kdig\OrientBundle\Entity\Potteryvoc\VocPotteryDecorationout", mappedBy="pottery", cascade={"persist"}, orphanRemoval=true) 
     * @GRID\Column(field="decorationout.name", title="Decoration Out", filter="select")
     */
    private $potdecorationout;
    
    /**
     * @ORM\OneToMany(targetEntity="Kdig\OrientBundle\Entity\Potteryvoc\VocPotteryDecorationinout", mappedBy="pottery", cascade={"persist"}, orphanRemoval=true) 
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
}