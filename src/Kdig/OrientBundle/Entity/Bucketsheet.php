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
 * @ORM\Table(name="bucketsheet", schema="public")
 * @Gedmo\Loggable
 */
class Bucketsheet {
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Gedmo\Versioned
     */
    private $id;
    
    /**
     * @Gedmo\Versioned
     * @ORM\Column(nullable=true, length=64, type="string")
     * 
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
     * @ORM\OneToOne(targetEntity="Bucket", inversedBy="bucketsheet", cascade={"persist"})
     */
    private $bucket;
    
    /**
     * @Gedmo\Versioned
     * @ORM\Column(nullable=true, name="is_read", type="boolean")
     */
    private $isread;
    
    /**
     * @Gedmo\Versioned
     * @ORM\Column(nullable=true, name="is_drawn", type="boolean")
     */
    private $isdrawn;
    
    /**
     * @Gedmo\Versioned
     * @ORM\Column(nullable=true, name="is_numbered", type="boolean")
     */
    private $isnumbered;
    
    /**
     * @Gedmo\Versioned
     * @ORM\Column(nullable=true, name="is_filed", type="boolean")
     */
    private $isfiled;
    
    /**
     * @Gedmo\Versioned
     * @ORM\Column(nullable=true, name="is_photographed", type="boolean")
     */
    private $isphotographed;
    /**
     *
     * @ORM\ManyToMany(targetEntity="Kdig\MediaBundle\Entity\Media", inversedBy="bucketsheets", cascade={"persist"})
     * @ORM\JoinTable(name="bucketsheet_media",
     *   joinColumns={@ORM\JoinColumn(nullable=true, name="bucketsheet_id", referencedColumnName="id", onDelete="SET NULL")},
     *   inverseJoinColumns={@ORM\JoinColumn(nullable=true, name="media_id", referencedColumnName="id", onDelete="SET NULL")}
     * )
     */
    private $media;
}