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
 * @ORM\Table(name="bucket", schema="public")
 * @Gedmo\Loggable
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Kdig\ArchaeologicalBundle\Entity\Repository\BucketRepository")
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
     * @ORM\ManyToOne(targetEntity="Kdig\ArchaeologicalBundle\Entity\Us", inversedBy="buckets", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true, name="us_id", referencedColumnName="id", onDelete="SET NULL")
     * @GRID\Column(field="us.name", title="Locus", size="40")
     * @GRID\Column(field="us.typeus.name", size="40", title="Type Locus", filter="select")
     * @GRID\Column(field="us.area.name", size="40", title="Area", filter="select")
     */
    private $us;
    
    /**
     * @ORM\OneToMany(targetEntity="Kdig\ArchaeologicalBundle\Entity\Prepottery", mappedBy="bucket", cascade={"persist"})
     */
    private $prepotterys;
    
    /**
     * @ORM\OneToMany(targetEntity="Kdig\ArchaeologicalBundle\Entity\Preobject", mappedBy="bucket", cascade={"persist"})
     */
    private $preobjects;
    
    /**
     * @ORM\OneToMany(targetEntity="Kdig\ArchaeologicalBundle\Entity\Presample", mappedBy="bucket", cascade={"persist"})
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
     * @ORM\OneToOne(targetEntity="Kdig\OrientBundle\Entity\Bucketsheet", inversedBy="bucket", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true, name="bucketsheet_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $bucketsheet;
    
    /**
     * @ORM\Column(nullable=true, type="string", length=255, name="image_name")
     *
     * @var string $imageName
     */
    protected $imageName;
}