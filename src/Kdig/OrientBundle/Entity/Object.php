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
 * @ORM\Table(name="object", schema="public")
 * @Gedmo\Loggable
 * @GRID\Source(columns="id, number, preobject.bucket.us.area.name, preobject.bucket.us.typeus.name, preobject.bucket.us.name, preobject.name, class.name, type.name, material.name, technique.name, decoration.name, preservation.name, dateobject.name, fragments, height, lenght, width, thickness, diameter, perforationdiameter, weight, bibliography, restorationdate, analysisdate, analysisreport, location, museum_acquisition, museum_acquisition_notes, exhibition_history, itaremarks, remarks, dateoofcontext, created")
 */
class Object {
    
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
     * @ORM\Column(nullable=true,length=64, type="integer", unique=true)
     * @Assert\Type(type="integer", message="The value {{ value }} is not a valid {{ type }}.")
     */
    private $number;
    
    /**
     * @Gedmo\Versioned
     * @ORM\Column(nullable=true,length=2048, type="text")
     */
    private $remarks;
    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(nullable=true,name="created", type="datetime")
     * @GRID\Column(type="date", size="40", filter="select")
     */
    private $created;

    /**
     * @Gedmo\Versioned
     * @ORM\Column(nullable=true,name="updated", type="datetime")
     * @Gedmo\Timestampable(on="update")
     */
    private $updated;
    
    /**
     * @Gedmo\Versioned
     * @ORM\Column(nullable=true,name="is_active", type="boolean")
     */
    private $isActive=true;
            
    /**
     * @Gedmo\Versioned
     * @ORM\Column(nullable=true,name="is_public", type="boolean")
     */
    private $isPublic=false;
    
    /**
     * @Gedmo\Versioned
     * @ORM\Column(nullable=true,name="is_delete", type="boolean")
     */
    private $isDelete=false;

    /**
     * @ORM\OneToOne(targetEntity="Kdig\ArchaeologicalBundle\Entity\Preobject", inversedBy="object", orphanRemoval=true)
     * @GRID\Column(field="preobject.name", title="Name")
     * @GRID\Column(field="preobject.bucket.us.name", title="Locus", size="40")
     * @GRID\Column(field="preobject.bucket.us.typeus.name", title="Type Locus", filter="select", size="40")
     * @GRID\Column(field="preobject.bucket.us.area.name", title="Area", filter="select", size="40")
     */
    private $preobject;
    
    /**
     * @Gedmo\Versioned
     * @ORM\Column(nullable=true, name="is_photographed", type="boolean")
     */
    private $isphotographed;
    
    /**
     * @Gedmo\Versioned
     * @ORM\Column(nullable=true, name="drawned", type="boolean")
     */
    private $drawned;
    
    /**
     * @ORM\ManyToOne(targetEntity="Kdig\ArchaelogicalBundle\Entity\Objectvoc\VocObjClass", inversedBy="object", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true, name="class_id", referencedColumnName="id", onDelete="SET NULL")
     * @GRID\Column(field="class.name", title="Class", filter="select")
     */
    private $class; //voc
    /**
     * @ORM\ManyToOne(targetEntity="Kdig\ArchaelogicalBundle\Entity\Objectvoc\VocObjType", inversedBy="object", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true, name="type_id", referencedColumnName="id", onDelete="SET NULL")
     * @GRID\Column(field="type.name", title="Type", filter="select")
     */
    private $type; //voc
    /**
     * @ORM\ManyToOne(targetEntity="Kdig\ArchaelogicalBundle\Entity\Objectvoc\VocObjMaterial", inversedBy="object", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true, name="material_id", referencedColumnName="id", onDelete="SET NULL")
     * @GRID\Column(field="material.name", title="Material", filter="select")
     */
    private $material; //voc
    
    /**
     * @ORM\ManyToOne(targetEntity="Kdig\ArchaelogicalBundle\Entity\Objectvoc\VocObjTechnique", inversedBy="object", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true, name="technique_id", referencedColumnName="id", onDelete="SET NULL")
     * @GRID\Column(field="technique.name", title="Technique", filter="select")
     */
    private $technique; //voc
    
    /**
     * @ORM\ManyToOne(targetEntity="Kdig\ArchaelogicalBundle\Entity\Objectvoc\VocObjDecoration", inversedBy="object", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true, name="decoration_id", referencedColumnName="id", onDelete="SET NULL")
     * @GRID\Column(field="decoration.name", title="Decoration", filter="select")
     */
    private $decoration; //voc
    
    /**
     * @ORM\ManyToOne(targetEntity="Kdig\ArchaelogicalBundle\Entity\Objectvoc\VocObjPreservation", inversedBy="object", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true, name="preservation_id", referencedColumnName="id", onDelete="SET NULL")
     * @GRID\Column(field="preservation.name", title="Preservation", filter="select")
     */
    private $preservation; //voc  

    /**
     * @ORM\ManyToOne(targetEntity="Kdig\ArchaelogicalBundle\Entity\Objectvoc\VocObjDate", inversedBy="object", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true, name="dateobject_id", referencedColumnName="id", onDelete="SET NULL")
     * @GRID\Column(field="datepbject.name", title="Periods", filter="select")
     */
    private $dateobject;
    /**
     * @Gedmo\Versioned
     * @ORM\Column(nullable=true,length=64, type="string")
     */
    private $fragments; //text
    
    /**
     * @Gedmo\Versioned
     * @ORM\Column(nullable=true,length=64, type="string")
     */
    private $inscription; //text
    
    /**
     * @Gedmo\Versioned
     * @ORM\Column(nullable=true,length=64, type="string")
     */
    private $dateoofcontext;
    /**
     * @Gedmo\Versioned
     * @ORM\Column(nullable=true,length=64, type="string")
     */
    private $height;
    
    /**
     * @Gedmo\Versioned
     * @ORM\Column(nullable=true,length=64, type="string")
     */
    private $lenght;
    
    /**
     * @Gedmo\Versioned
     * @ORM\Column(nullable=true,length=64, type="string")
     */
    private $width; 
    
    /**
     * @Gedmo\Versioned
     * @ORM\Column(nullable=true,length=64, type="string")
     */
    private $thickness; 
    /**
     * @Gedmo\Versioned
     * @ORM\Column(nullable=true,length=64, type="string")
     */
    private $diameter;
    
    /**
     * @Gedmo\Versioned
     * @ORM\Column(nullable=true,length=64, type="string")
     */
    private $perforationdiameter;
    
    /**
     * @Gedmo\Versioned
     * @ORM\Column(nullable=true,length=64, type="string")
     */
    private $weight;
    
    /**
     * @Gedmo\Versioned
     * @ORM\Column(nullable=true,length=64, type="string")
     */
    private $bibliography;
    
    /**
     * @ORM\Column(nullable=true,name="restorationdate", type="datetime")
     * @GRID\Column(type="date", size="40", filter="select")
     */
    private $restorationdate;
    
    /**
     * @ORM\Column(nullable=true,name="analysisdate", type="datetime")
     * @GRID\Column(type="date", size="40", filter="select")
     */
    private $analysisdate;
    
    /**
     * @Gedmo\Versioned
     * @ORM\Column(nullable=true,length=2048, type="text")
     */
    private $analysisreport;
    
    /**
     * @Gedmo\Versioned
     * @ORM\Column(nullable=true,length=64, type="string")
     */
    private $location;
    
    /**
     * @Gedmo\Versioned
     * @ORM\Column(nullable=true,length=64, type="string")
     */
    private $museum_acquisition;
    
    /**
     * @Gedmo\Versioned
     * @ORM\Column(nullable=true,length=2048, type="text")
     */
    private $museum_acquisition_notes;
    
    /**
     * @Gedmo\Versioned
     * @ORM\Column(nullable=true,length=2048, type="text")
     */
    private $exhibition_history;
    
    /**
     * @Gedmo\Versioned
     * @ORM\Column(nullable=true,length=2048, type="text")
     */
    private $itaremarks;
    
    /**
     *
     * @ORM\ManyToMany(targetEntity="Media", inversedBy="objects", cascade={"persist"})
     * @ORM\JoinTable(name="object_media",
     *   joinColumns={@ORM\JoinColumn(nullable=true, name="object_id", referencedColumnName="id", onDelete="SET NULL")},
     *   inverseJoinColumns={@ORM\JoinColumn(nullable=true, name="media_id", referencedColumnName="id", onDelete="SET NULL")}
     * )
     */
    public $media; 
    
}