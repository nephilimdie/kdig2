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
     * @ORM\ManyToOne(targetEntity="Kdig\OrientBundle\Entity\Objectvoc\VocObjClass", inversedBy="object", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true, name="class_id", referencedColumnName="id", onDelete="SET NULL")
     * @GRID\Column(field="class.name", title="Class", filter="select")
     */
    private $class; //voc
    /**
     * @ORM\ManyToOne(targetEntity="Kdig\OrientBundle\Entity\Objectvoc\VocObjType", inversedBy="object", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true, name="type_id", referencedColumnName="id", onDelete="SET NULL")
     * @GRID\Column(field="type.name", title="Type", filter="select")
     */
    private $type; //voc
    /**
     * @ORM\ManyToOne(targetEntity="Kdig\OrientBundle\Entity\Objectvoc\VocObjMaterial", inversedBy="object", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true, name="material_id", referencedColumnName="id", onDelete="SET NULL")
     * @GRID\Column(field="material.name", title="Material", filter="select")
     */
    private $material; //voc
    
    /**
     * @ORM\ManyToOne(targetEntity="Kdig\OrientBundle\Entity\Objectvoc\VocObjTechnique", inversedBy="object", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true, name="technique_id", referencedColumnName="id", onDelete="SET NULL")
     * @GRID\Column(field="technique.name", title="Technique", filter="select")
     */
    private $technique; //voc
    
    /**
     * @ORM\ManyToOne(targetEntity="Kdig\OrientBundle\Entity\Objectvoc\VocObjDecoration", inversedBy="object", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true, name="decoration_id", referencedColumnName="id", onDelete="SET NULL")
     * @GRID\Column(field="decoration.name", title="Decoration", filter="select")
     */
    private $decoration; //voc
    
    /**
     * @ORM\ManyToOne(targetEntity="Kdig\OrientBundle\Entity\Objectvoc\VocObjPreservation", inversedBy="object", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true, name="preservation_id", referencedColumnName="id", onDelete="SET NULL")
     * @GRID\Column(field="preservation.name", title="Preservation", filter="select")
     */
    private $preservation; //voc  

    /**
     * @ORM\ManyToOne(targetEntity="Kdig\OrientBundle\Entity\Objectvoc\VocObjDate", inversedBy="object", cascade={"persist"})
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    public function __tostring() 
    {
        return (string)$this->getName();
    }
    /**
     * Set number
     *
     * @param integer $number
     * @return Object
     */
    public function setNumber($number)
    {
        $this->number = $number;
    
        return $this;
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
     * @param string $remarks
     * @return Object
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
     * @return Object
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
     * @return Object
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
     * @return Object
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
     * @return Object
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
     * @return Object
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
     * Set isphotographed
     *
     * @param boolean $isphotographed
     * @return Object
     */
    public function setIsphotographed($isphotographed)
    {
        $this->isphotographed = $isphotographed;
    
        return $this;
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
     * Set drawned
     *
     * @param boolean $drawned
     * @return Object
     */
    public function setDrawned($drawned)
    {
        $this->drawned = $drawned;
    
        return $this;
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

    /**
     * Set fragments
     *
     * @param string $fragments
     * @return Object
     */
    public function setFragments($fragments)
    {
        $this->fragments = $fragments;
    
        return $this;
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
     * @return Object
     */
    public function setInscription($inscription)
    {
        $this->inscription = $inscription;
    
        return $this;
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
     * @return Object
     */
    public function setDateoofcontext($dateoofcontext)
    {
        $this->dateoofcontext = $dateoofcontext;
    
        return $this;
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
     * @return Object
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
     * Set lenght
     *
     * @param string $lenght
     * @return Object
     */
    public function setLenght($lenght)
    {
        $this->lenght = $lenght;
    
        return $this;
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
     * @return Object
     */
    public function setWidth($width)
    {
        $this->width = $width;
    
        return $this;
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
     * @return Object
     */
    public function setThickness($thickness)
    {
        $this->thickness = $thickness;
    
        return $this;
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
     * @return Object
     */
    public function setDiameter($diameter)
    {
        $this->diameter = $diameter;
    
        return $this;
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
     * @return Object
     */
    public function setPerforationdiameter($perforationdiameter)
    {
        $this->perforationdiameter = $perforationdiameter;
    
        return $this;
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
     * @return Object
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;
    
        return $this;
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
     * @return Object
     */
    public function setBibliography($bibliography)
    {
        $this->bibliography = $bibliography;
    
        return $this;
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
     * @param \DateTime $restorationdate
     * @return Object
     */
    public function setRestorationdate($restorationdate)
    {
        $this->restorationdate = $restorationdate;
    
        return $this;
    }

    /**
     * Get restorationdate
     *
     * @return \DateTime 
     */
    public function getRestorationdate()
    {
        return $this->restorationdate;
    }

    /**
     * Set analysisdate
     *
     * @param \DateTime $analysisdate
     * @return Object
     */
    public function setAnalysisdate($analysisdate)
    {
        $this->analysisdate = $analysisdate;
    
        return $this;
    }

    /**
     * Get analysisdate
     *
     * @return \DateTime 
     */
    public function getAnalysisdate()
    {
        return $this->analysisdate;
    }

    /**
     * Set analysisreport
     *
     * @param string $analysisreport
     * @return Object
     */
    public function setAnalysisreport($analysisreport)
    {
        $this->analysisreport = $analysisreport;
    
        return $this;
    }

    /**
     * Get analysisreport
     *
     * @return string 
     */
    public function getAnalysisreport()
    {
        return $this->analysisreport;
    }

    /**
     * Set location
     *
     * @param string $location
     * @return Object
     */
    public function setLocation($location)
    {
        $this->location = $location;
    
        return $this;
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
     * @return Object
     */
    public function setMuseumAcquisition($museumAcquisition)
    {
        $this->museum_acquisition = $museumAcquisition;
    
        return $this;
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
     * @param string $museumAcquisitionNotes
     * @return Object
     */
    public function setMuseumAcquisitionNotes($museumAcquisitionNotes)
    {
        $this->museum_acquisition_notes = $museumAcquisitionNotes;
    
        return $this;
    }

    /**
     * Get museum_acquisition_notes
     *
     * @return string 
     */
    public function getMuseumAcquisitionNotes()
    {
        return $this->museum_acquisition_notes;
    }

    /**
     * Set exhibition_history
     *
     * @param string $exhibitionHistory
     * @return Object
     */
    public function setExhibitionHistory($exhibitionHistory)
    {
        $this->exhibition_history = $exhibitionHistory;
    
        return $this;
    }

    /**
     * Get exhibition_history
     *
     * @return string 
     */
    public function getExhibitionHistory()
    {
        return $this->exhibition_history;
    }

    /**
     * Set itaremarks
     *
     * @param string $itaremarks
     * @return Object
     */
    public function setItaremarks($itaremarks)
    {
        $this->itaremarks = $itaremarks;
    
        return $this;
    }

    /**
     * Get itaremarks
     *
     * @return string 
     */
    public function getItaremarks()
    {
        return $this->itaremarks;
    }

    /**
     * Set preobject
     *
     * @param \Kdig\ArchaeologicalBundle\Entity\Preobject $preobject
     * @return Object
     */
    public function setPreobject(\Kdig\ArchaeologicalBundle\Entity\Preobject $preobject = null)
    {
        $this->preobject = $preobject;
    
        return $this;
    }

    /**
     * Get preobject
     *
     * @return \Kdig\ArchaeologicalBundle\Entity\Preobject 
     */
    public function getPreobject()
    {
        return $this->preobject;
    }

    /**
     * Set class
     *
     * @param \Kdig\OrientBundle\Entity\Objectvoc\VocObjClass $class
     * @return Object
     */
    public function setClass(\Kdig\OrientBundle\Entity\Objectvoc\VocObjClass $class = null)
    {
        $this->class = $class;
    
        return $this;
    }

    /**
     * Get class
     *
     * @return \Kdig\OrientBundle\Entity\Objectvoc\VocObjClass 
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * Set type
     *
     * @param \Kdig\OrientBundle\Entity\Objectvoc\VocObjType $type
     * @return Object
     */
    public function setType(\Kdig\OrientBundle\Entity\Objectvoc\VocObjType $type = null)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return \Kdig\OrientBundle\Entity\Objectvoc\VocObjType 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set material
     *
     * @param \Kdig\OrientBundle\Entity\Objectvoc\VocObjMaterial $material
     * @return Object
     */
    public function setMaterial(\Kdig\OrientBundle\Entity\Objectvoc\VocObjMaterial $material = null)
    {
        $this->material = $material;
    
        return $this;
    }

    /**
     * Get material
     *
     * @return \Kdig\OrientBundle\Entity\Objectvoc\VocObjMaterial 
     */
    public function getMaterial()
    {
        return $this->material;
    }

    /**
     * Set technique
     *
     * @param \Kdig\OrientBundle\Entity\Objectvoc\VocObjTechnique $technique
     * @return Object
     */
    public function setTechnique(\Kdig\OrientBundle\Entity\Objectvoc\VocObjTechnique $technique = null)
    {
        $this->technique = $technique;
    
        return $this;
    }

    /**
     * Get technique
     *
     * @return \Kdig\OrientBundle\Entity\Objectvoc\VocObjTechnique 
     */
    public function getTechnique()
    {
        return $this->technique;
    }

    /**
     * Set decoration
     *
     * @param \Kdig\OrientBundle\Entity\Objectvoc\VocObjDecoration $decoration
     * @return Object
     */
    public function setDecoration(\Kdig\OrientBundle\Entity\Objectvoc\VocObjDecoration $decoration = null)
    {
        $this->decoration = $decoration;
    
        return $this;
    }

    /**
     * Get decoration
     *
     * @return \Kdig\OrientBundle\Entity\Objectvoc\VocObjDecoration 
     */
    public function getDecoration()
    {
        return $this->decoration;
    }

    /**
     * Set preservation
     *
     * @param \Kdig\OrientBundle\Entity\Objectvoc\VocObjPreservation $preservation
     * @return Object
     */
    public function setPreservation(\Kdig\OrientBundle\Entity\Objectvoc\VocObjPreservation $preservation = null)
    {
        $this->preservation = $preservation;
    
        return $this;
    }

    /**
     * Get preservation
     *
     * @return \Kdig\OrientBundle\Entity\Objectvoc\VocObjPreservation 
     */
    public function getPreservation()
    {
        return $this->preservation;
    }

    /**
     * Set dateobject
     *
     * @param \Kdig\OrientBundle\Entity\Objectvoc\VocObjDate $dateobject
     * @return Object
     */
    public function setDateobject(\Kdig\OrientBundle\Entity\Objectvoc\VocObjDate $dateobject = null)
    {
        $this->dateobject = $dateobject;
    
        return $this;
    }

    /**
     * Get dateobject
     *
     * @return \Kdig\OrientBundle\Entity\Objectvoc\VocObjDate 
     */
    public function getDateobject()
    {
        return $this->dateobject;
    }
}