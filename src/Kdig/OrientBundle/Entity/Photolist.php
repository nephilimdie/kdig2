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
 * @ORM\Table(name="photolist", schema="public")
 * @Gedmo\Loggable
 */
class Photolist {
    
    /**
     * @ORM\Id
     * @ORM\Column( type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Gedmo\Versioned
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
     * @ORM\ManyToOne(targetEntity="VocMachine", inversedBy="photolist")
     * @ORM\JoinColumn(nullable=true, name="vocmachine_id", referencedColumnName="id", onDelete="SET NULL")
     * @Assert\NotBlank()
     */
    protected $vocmachine;
    
    /**
     * @Gedmo\Versioned
     * @ORM\Column(nullable=true, length=10, type="integer")
     */
    private $fromnumber;
    
    /**
     * @Gedmo\Versioned
     * @ORM\Column(nullable=true, length=10, type="integer")
     */
    private $tonumber;
    
    /** 
     * @ManyToMany(targetEntity="Kdig\OrientBundle\Entity\Object")
     * @JoinTable(name="photolists_Objects",
     *      joinColumns={@JoinColumn(name="photolist_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="object_id", referencedColumnName="id")}
     *      )
     * @ORM\OneToMany(targetEntity="", mappedBy="class", cascade={"persist"}) 
     */
    private $object;
    
    /** 
     * @ManyToMany(targetEntity="Kdig\OrientBundle\Entity\Pottery")
     * @JoinTable(name="photolists_Potterys",
     *      joinColumns={@JoinColumn(name="photolist_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="pottery_id", referencedColumnName="id")}
     *      )
     */
    private $pottery;
    
    /** 
     * @ManyToMany(targetEntity="Kdig\OrientBundle\Entity\Sample")
     * @JoinTable(name="photolists_Samples",
     *      joinColumns={@JoinColumn(name="photolist_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="sample_id", referencedColumnName="id")}
     *      )
     */
    private $sample;
    
    /** 
     * @ManyToMany(targetEntity="Kdig\ArchaeologicalBundle\Entity\Us")
     * @JoinTable(name="photolists_Uss",
     *      joinColumns={@JoinColumn(name="photolist_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="us_id", referencedColumnName="id")}
     *      )
     */
    private $us;
    
    /** 
     * @ManyToMany(targetEntity="Kdig\ArchaeologicalBundle\Entity\Area")
     * @JoinTable(name="photolists_areas",
     *      joinColumns={@JoinColumn(name="photolist_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="area_id", referencedColumnName="id")}
     *      )
     */
    private $area;
    
}