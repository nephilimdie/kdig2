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
 * @ORM\Table(name="area", schema="public")
 * @Gedmo\Loggable
 */
class Area {

    /**
     * @ORM\Id
     * @ORM\Column( type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Gedmo\Versioned
     */
    private $id;
    
    /**
     * @Gedmo\Versioned
     * @ORM\Column(nullable=true, length=64, type="string")
     * @Assert\NotBlank()
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
     * @ORM\ManyToOne(targetEntity="VocAreaType", inversedBy="area")
     * @ORM\JoinColumn(nullable=true, name="vocareatype_id", referencedColumnName="id", onDelete="SET NULL")
     * @Assert\NotBlank()
     */
    protected $type;
    
    /**
     * @ORM\OneToMany(targetEntity="Us", mappedBy="area", cascade={"persist"})
     */
    private $uss;
    
    /**
     * @ORM\ManyToMany(targetEntity="Kdig\MediaBundle\Entty\Media", inversedBy="areas", cascade={"persist"})
     * @ORM\JoinTable(
     *   name="area_media",
     *   joinColumns={@ORM\JoinColumn(nullable=true, name="area_id", referencedColumnName="id")},
     *   inverseJoinColumns={@ORM\JoinColumn(nullable=true, name="media_id", referencedColumnName="id")}
     * )
     */
    private $media;
    
    /**
     * @Gedmo\Versioned
     * @ORM\Column(nullable=true, length=5, type="integer")
     */
    private $fromrefbucket;
    
    /**
     * @Gedmo\Versioned
     * @ORM\Column(nullable=true, length=5, type="integer")
     */
    private $torefbucket;
    
    /**
     * @Gedmo\Versioned
     * @ORM\Column(nullable=true, length=5, type="integer")
     */
    private $fromrefus;
    
    /**
     * @Gedmo\Versioned
     * @ORM\Column(nullable=true, length=5, type="integer")
     */
    private $torefus;
    
    /**
     * @ORM\ManyToMany(targetEntity="Kdig\UserBundle\Entity\Group", inversedBy="areas", cascade={"persist"})
     * @ORM\JoinTable(name="areas_groups",
     *      joinColumns={@ORM\JoinColumn(name="area_id", referencedColumnName="id", onDelete="SET NULL")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id", onDelete="SET NULL")}
     * )
     */
    private $groups;
    
    /**
     * @ORM\OneToMany(targetEntity="Kdig\UserBundle\Entity\User", mappedBy="slectedarea", cascade={"persist"})
     */
    private $userprofilearea;
    
    public function __tostring() 
    {
        return $this->getName();
    }
}