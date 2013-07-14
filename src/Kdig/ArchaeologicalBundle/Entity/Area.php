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
     * @ORM\ManyToMany(targetEntity="Kdig\MediaBundle\Entity\Media", inversedBy="areas", cascade={"persist"})
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
        return (string)$this->getName();
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->uss = new \Doctrine\Common\Collections\ArrayCollection();
        $this->media = new \Doctrine\Common\Collections\ArrayCollection();
        $this->groups = new \Doctrine\Common\Collections\ArrayCollection();
        $this->userprofilearea = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set name
     *
     * @param string $name
     * @return Area
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set remarks
     *
     * @param string $remarks
     * @return Area
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
     * @return Area
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
     * @return Area
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
     * @return Area
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
     * @return Area
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
     * @return Area
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
     * Set fromrefbucket
     *
     * @param integer $fromrefbucket
     * @return Area
     */
    public function setFromrefbucket($fromrefbucket)
    {
        $this->fromrefbucket = $fromrefbucket;
    
        return $this;
    }

    /**
     * Get fromrefbucket
     *
     * @return integer 
     */
    public function getFromrefbucket()
    {
        return $this->fromrefbucket;
    }

    /**
     * Set torefbucket
     *
     * @param integer $torefbucket
     * @return Area
     */
    public function setTorefbucket($torefbucket)
    {
        $this->torefbucket = $torefbucket;
    
        return $this;
    }

    /**
     * Get torefbucket
     *
     * @return integer 
     */
    public function getTorefbucket()
    {
        return $this->torefbucket;
    }

    /**
     * Set fromrefus
     *
     * @param integer $fromrefus
     * @return Area
     */
    public function setFromrefus($fromrefus)
    {
        $this->fromrefus = $fromrefus;
    
        return $this;
    }

    /**
     * Get fromrefus
     *
     * @return integer 
     */
    public function getFromrefus()
    {
        return $this->fromrefus;
    }

    /**
     * Set torefus
     *
     * @param integer $torefus
     * @return Area
     */
    public function setTorefus($torefus)
    {
        $this->torefus = $torefus;
    
        return $this;
    }

    /**
     * Get torefus
     *
     * @return integer 
     */
    public function getTorefus()
    {
        return $this->torefus;
    }

    /**
     * Set type
     *
     * @param \Kdig\ArchaeologicalBundle\Entity\VocAreaType $type
     * @return Area
     */
    public function setType(\Kdig\ArchaeologicalBundle\Entity\VocAreaType $type = null)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return \Kdig\ArchaeologicalBundle\Entity\VocAreaType 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Add uss
     *
     * @param \Kdig\ArchaeologicalBundle\Entity\Us $uss
     * @return Area
     */
    public function addUs(\Kdig\ArchaeologicalBundle\Entity\Us $uss)
    {
        $this->uss[] = $uss;
    
        return $this;
    }

    /**
     * Remove uss
     *
     * @param \Kdig\ArchaeologicalBundle\Entity\Us $uss
     */
    public function removeUs(\Kdig\ArchaeologicalBundle\Entity\Us $uss)
    {
        $this->uss->removeElement($uss);
    }

    /**
     * Get uss
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUss()
    {
        return $this->uss;
    }

    /**
     * Add media
     *
     * @param \Kdig\MediaBundle\Entity\Media $media
     * @return Area
     */
    public function addMedia(\Kdig\MediaBundle\Entity\Media $media)
    {
        $this->media[] = $media;
    
        return $this;
    }

    /**
     * Remove media
     *
     * @param \Kdig\MediaBundle\Entity\Media $media
     */
    public function removeMedia(\Kdig\MediaBundle\Entity\Media $media)
    {
        $this->media->removeElement($media);
    }

    /**
     * Get media
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMedia()
    {
        return $this->media;
    }

    /**
     * Add groups
     *
     * @param \Kdig\UserBundle\Entity\Group $groups
     * @return Area
     */
    public function addGroup(\Kdig\UserBundle\Entity\Group $groups)
    {
        $this->groups[] = $groups;
    
        return $this;
    }

    /**
     * Remove groups
     *
     * @param \Kdig\UserBundle\Entity\Group $groups
     */
    public function removeGroup(\Kdig\UserBundle\Entity\Group $groups)
    {
        $this->groups->removeElement($groups);
    }

    /**
     * Get groups
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * Add userprofilearea
     *
     * @param \Kdig\UserBundle\Entity\User $userprofilearea
     * @return Area
     */
    public function addUserprofilearea(\Kdig\UserBundle\Entity\User $userprofilearea)
    {
        $this->userprofilearea[] = $userprofilearea;
    
        return $this;
    }

    /**
     * Remove userprofilearea
     *
     * @param \Kdig\UserBundle\Entity\User $userprofilearea
     */
    public function removeUserprofilearea(\Kdig\UserBundle\Entity\User $userprofilearea)
    {
        $this->userprofilearea->removeElement($userprofilearea);
    }

    /**
     * Get userprofilearea
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUserprofilearea()
    {
        return $this->userprofilearea;
    }
}