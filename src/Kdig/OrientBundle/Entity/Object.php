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
     * @ORM\OneToOne(targetEntity="Preobject", inversedBy="object", cascade={"persist"}, orphanRemoval=true)
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
     * @ORM\ManyToOne(targetEntity="VocObjClass", inversedBy="object", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true, name="class_id", referencedColumnName="id", onDelete="SET NULL")
     * @GRID\Column(field="class.name", title="Class", filter="select")
     */
    private $class; //voc
    /**
     * @ORM\ManyToOne(targetEntity="VocObjType", inversedBy="object", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true, name="type_id", referencedColumnName="id", onDelete="SET NULL")
     * @GRID\Column(field="type.name", title="Type", filter="select")
     */
    private $type; //voc
    /**
     * @ORM\ManyToOne(targetEntity="VocObjMaterial", inversedBy="object", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true, name="material_id", referencedColumnName="id", onDelete="SET NULL")
     * @GRID\Column(field="material.name", title="Material", filter="select")
     */
    private $material; //voc
    
    /**
     * @ORM\ManyToOne(targetEntity="VocObjTechnique", inversedBy="object", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true, name="technique_id", referencedColumnName="id", onDelete="SET NULL")
     * @GRID\Column(field="technique.name", title="Technique", filter="select")
     */
    private $technique; //voc
    
    /**
     * @ORM\ManyToOne(targetEntity="VocObjDecoration", inversedBy="object", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true, name="decoration_id", referencedColumnName="id", onDelete="SET NULL")
     * @GRID\Column(field="decoration.name", title="Decoration", filter="select")
     */
    private $decoration; //voc
    
    /**
     * @ORM\ManyToOne(targetEntity="VocObjPreservation", inversedBy="object", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true, name="preservation_id", referencedColumnName="id", onDelete="SET NULL")
     * @GRID\Column(field="preservation.name", title="Preservation", filter="select")
     */
    private $preservation; //voc  

    /**
     * @ORM\ManyToOne(targetEntity="VocObjDate", inversedBy="object", cascade={"persist"})
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
    
    /**
     * @Gedmo\Versioned
     * @ORM\Column(nullable=true,length=64, type="string")
     */
    private $otherid;
    
    /**
     * @Gedmo\Versioned
     * @ORM\Column(nullable=true,length=64, type="string")
     */
    private $anotherid;
    
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
     * Set number
     *
     * @param integer $number
     */
    public function setNumber($number)
    {
        $this->number = $number;
    }

    /**
     * Get number
     *
     * @return integer 
     */
    public function getNumber()
    {
        return $this->number;
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
     * Set fragments
     *
     * @param string $fragments
     */
    public function setFragments($fragments)
    {
        $this->fragments = $fragments;
    }

    /**
     * Get fragments
     *
     * @return string 
     */
    public function getFragments()
    {
        return $this->fragments;
    }

    /**
     * Set inscription
     *
     * @param string $inscription
     */
    public function setInscription($inscription)
    {
        $this->inscription = $inscription;
    }

    /**
     * Get inscription
     *
     * @return string 
     */
    public function getInscription()
    {
        return $this->inscription;
    }

    /**
     * Set dateoofcontext
     *
     * @param string $dateoofcontext
     */
    public function setDateoofcontext($dateoofcontext)
    {
        $this->dateoofcontext = $dateoofcontext;
    }

    /**
     * Get dateoofcontext
     *
     * @return string 
     */
    public function getDateoofcontext()
    {
        return $this->dateoofcontext;
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
     * Set lenght
     *
     * @param string $lenght
     */
    public function setLenght($lenght)
    {
        $this->lenght = $lenght;
    }

    /**
     * Get lenght
     *
     * @return string 
     */
    public function getLenght()
    {
        return $this->lenght;
    }

    /**
     * Set width
     *
     * @param string $width
     */
    public function setWidth($width)
    {
        $this->width = $width;
    }

    /**
     * Get width
     *
     * @return string 
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Set thickness
     *
     * @param string $thickness
     */
    public function setThickness($thickness)
    {
        $this->thickness = $thickness;
    }

    /**
     * Get thickness
     *
     * @return string 
     */
    public function getThickness()
    {
        return $this->thickness;
    }

    /**
     * Set diameter
     *
     * @param string $diameter
     */
    public function setDiameter($diameter)
    {
        $this->diameter = $diameter;
    }

    /**
     * Get diameter
     *
     * @return string 
     */
    public function getDiameter()
    {
        return $this->diameter;
    }

    /**
     * Set perforationdiameter
     *
     * @param string $perforationdiameter
     */
    public function setPerforationdiameter($perforationdiameter)
    {
        $this->perforationdiameter = $perforationdiameter;
    }

    /**
     * Get perforationdiameter
     *
     * @return string 
     */
    public function getPerforationdiameter()
    {
        return $this->perforationdiameter;
    }

    /**
     * Set weight
     *
     * @param string $weight
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;
    }

    /**
     * Get weight
     *
     * @return string 
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * Set bibliography
     *
     * @param string $bibliography
     */
    public function setBibliography($bibliography)
    {
        $this->bibliography = $bibliography;
    }

    /**
     * Get bibliography
     *
     * @return string 
     */
    public function getBibliography()
    {
        return $this->bibliography;
    }

    /**
     * Set restorationdate
     *
     * @param datetime $restorationdate
     */
    public function setRestorationdate($restorationdate)
    {
        $this->restorationdate = $restorationdate;
    }

    /**
     * Get restorationdate
     *
     * @return datetime 
     */
    public function getRestorationdate()
    {
        return $this->restorationdate;
    }

    /**
     * Set analysisdate
     *
     * @param datetime $analysisdate
     */
    public function setAnalysisdate($analysisdate)
    {
        $this->analysisdate = $analysisdate;
    }

    /**
     * Get analysisdate
     *
     * @return datetime 
     */
    public function getAnalysisdate()
    {
        return $this->analysisdate;
    }

    /**
     * Set analysisreport
     *
     * @param text $analysisreport
     */
    public function setAnalysisreport($analysisreport)
    {
        $this->analysisreport = $analysisreport;
    }

    /**
     * Get analysisreport
     *
     * @return text 
     */
    public function getAnalysisreport()
    {
        return $this->analysisreport;
    }

    /**
     * Set location
     *
     * @param string $location
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }

    /**
     * Get location
     *
     * @return string 
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set museum_acquisition
     *
     * @param string $museumAcquisition
     */
    public function setMuseumAcquisition($museumAcquisition)
    {
        $this->museum_acquisition = $museumAcquisition;
    }

    /**
     * Get museum_acquisition
     *
     * @return string 
     */
    public function getMuseumAcquisition()
    {
        return $this->museum_acquisition;
    }

    /**
     * Set museum_acquisition_notes
     *
     * @param text $museumAcquisitionNotes
     */
    public function setMuseumAcquisitionNotes($museumAcquisitionNotes)
    {
        $this->museum_acquisition_notes = $museumAcquisitionNotes;
    }

    /**
     * Get museum_acquisition_notes
     *
     * @return text 
     */
    public function getMuseumAcquisitionNotes()
    {
        return $this->museum_acquisition_notes;
    }

    /**
     * Set exhibition_history
     *
     * @param text $exhibitionHistory
     */
    public function setExhibitionHistory($exhibitionHistory)
    {
        $this->exhibition_history = $exhibitionHistory;
    }

    /**
     * Get exhibition_history
     *
     * @return text 
     */
    public function getExhibitionHistory()
    {
        return $this->exhibition_history;
    }

    /**
     * Set itaremarks
     *
     * @param text $itaremarks
     */
    public function setItaremarks($itaremarks)
    {
        $this->itaremarks = $itaremarks;
    }

    /**
     * Get itaremarks
     *
     * @return text 
     */
    public function getItaremarks()
    {
        return $this->itaremarks;
    }

    /**
     * Set otherid
     *
     * @param string $otherid
     */
    public function setOtherid($otherid)
    {
        $this->otherid = $otherid;
    }

    /**
     * Get otherid
     *
     * @return string 
     */
    public function getOtherid()
    {
        return $this->otherid;
    }

    /**
     * Set anotherid
     *
     * @param string $anotherid
     */
    public function setAnotherid($anotherid)
    {
        $this->anotherid = $anotherid;
    }

    /**
     * Get anotherid
     *
     * @return string 
     */
    public function getAnotherid()
    {
        return $this->anotherid;
    }

    /**
     * Set preobject
     *
     * @param Kdig\ArchaelogicalBundle\Entity\Preobject $preobject
     */
    public function setPreobject($preobject)
    {
        $this->preobject = $preobject;
    }

    /**
     * Get preobject
     *
     * @return Kdig\ArchaelogicalBundle\Entity\Preobject 
     */
    public function getPreobject()
    {
        return $this->preobject;
    }

    /**
     * Set class
     *
     * @param Kdig\ArchaelogicalBundle\Entity\VocObjClass $class
     */
    public function setClass(\Kdig\ArchaelogicalBundle\Entity\VocObjClass $class)
    {
        $this->class = $class;
    }

    /**
     * Get class
     *
     * @return Kdig\ArchaelogicalBundle\Entity\VocObjClass 
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * Set type
     *
     * @param Kdig\ArchaelogicalBundle\Entity\VocObjType $type
     */
    public function setType(\Kdig\ArchaelogicalBundle\Entity\VocObjType $type)
    {
        $this->type = $type;
    }

    /**
     * Get type
     *
     * @return Kdig\ArchaelogicalBundle\Entity\VocObjType 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set material
     *
     * @param Kdig\ArchaelogicalBundle\Entity\VocObjMaterial $material
     */
    public function setMaterial(\Kdig\ArchaelogicalBundle\Entity\VocObjMaterial $material)
    {
        $this->material = $material;
    }

    /**
     * Get material
     *
     * @return Kdig\ArchaelogicalBundle\Entity\VocObjMaterial 
     */
    public function getMaterial()
    {
        return $this->material;
    }

    /**
     * Set technique
     *
     * @param Kdig\ArchaelogicalBundle\Entity\VocObjTechnique $technique
     */
    public function setTechnique(\Kdig\ArchaelogicalBundle\Entity\VocObjTechnique $technique)
    {
        $this->technique = $technique;
    }

    /**
     * Get technique
     *
     * @return Kdig\ArchaelogicalBundle\Entity\VocObjTechnique 
     */
    public function getTechnique()
    {
        return $this->technique;
    }

    /**
     * Set decoration
     *
     * @param Kdig\ArchaelogicalBundle\Entity\VocObjDecoration $decoration
     */
    public function setDecoration(\Kdig\ArchaelogicalBundle\Entity\VocObjDecoration $decoration)
    {
        $this->decoration = $decoration;
    }

    /**
     * Get decoration
     *
     * @return Kdig\ArchaelogicalBundle\Entity\VocObjDecoration 
     */
    public function getDecoration()
    {
        return $this->decoration;
    }

    /**
     * Set preservation
     *
     * @param Kdig\ArchaelogicalBundle\Entity\VocObjPreservation $preservation
     */
    public function setPreservation(\Kdig\ArchaelogicalBundle\Entity\VocObjPreservation $preservation)
    {
        $this->preservation = $preservation;
    }

    /**
     * Get preservation
     *
     * @return Kdig\ArchaelogicalBundle\Entity\VocObjPreservation 
     */
    public function getPreservation()
    {
        return $this->preservation;
    }

    /**
     * Set dateobject
     *
     * @param Kdig\ArchaelogicalBundle\Entity\VocObjDate $dateobject
     */
    public function setDateobject(\Kdig\ArchaelogicalBundle\Entity\VocObjDate $dateobject)
    {
        $this->dateobject = $dateobject;
    }

    /**
     * Get dateobject
     *
     * @return Kdig\ArchaelogicalBundle\Entity\VocObjDate 
     */
    public function getDateobject()
    {
        return $this->dateobject;
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
     * Set drawned
     *
     * @param boolean $drawned
     */
    public function setDrawned($drawned)
    {
        $this->drawned = $drawned;
    }

    /**
     * Get drawned
     *
     * @return boolean 
     */
    public function getDrawned()
    {
        return $this->drawned;
    }
}