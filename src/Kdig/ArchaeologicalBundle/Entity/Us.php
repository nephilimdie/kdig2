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

/**
 * @ORM\Entity
 * @ORM\Table(name="us", schema="public")
 * @Gedmo\Loggable
 * @ORM\Entity(repositoryClass="Kdig\ArchaelogicalBundle\Repository\UsRepository")
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
}