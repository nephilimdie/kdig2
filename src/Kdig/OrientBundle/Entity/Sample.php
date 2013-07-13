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
 * @ORM\Table(name="sample", schema="public")
 * @Gedmo\Loggable
 * @GRID\Source(columns="id, presample.bucket.us.area.name, presample.bucket.us.typeus.name, presample.bucket.us.name, presample.bucket.name, presample.name, name, type, isActive, isDelete, isPublic, created")
 */
class Sample {
    
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
     * @ORM\OneToOne(targetEntity="Kdig\ArchaeologicalBundle\Entity\Presample", inversedBy="sample", orphanRemoval=true)
     * @GRID\Column(field="presample.bucket.name", title="Bucket")
     * @GRID\Column(field="presample.bucket.us.name", title="Locus", size="40")
     * @GRID\Column(field="presample.bucket.us.typeus.name", title="Type Locus", filter="select", size="40")
     * @GRID\Column(field="presample.bucket.us.area.name", title="Area", filter="select", size="40")
     */
    private $presample;
    
    /**
     * @ORM\OneToMany(targetEntity="\Kdig\ArchaelogicalBundle\Entity\Samplevoc\VocSampleType", mappedBy="sample")
     * @GRID\Column(field="type.name", title="Type")
     * @GRID\Column(field="type.name", title="Type", filter="select")
     */
    protected $type;
    
    /**
     *
     * @ORM\ManyToMany(targetEntity="Media", inversedBy="smaples", cascade={"persist"})
     * @ORM\JoinTable(name="sample_media",
     *   joinColumns={@ORM\JoinColumn(nullable=true, name="sample_id", referencedColumnName="id", onDelete="SET NULL")},
     *   inverseJoinColumns={@ORM\JoinColumn(nullable=true, name="media_id", referencedColumnName="id", onDelete="SET NULL")}
     * )
     */
    private $media;
    
}