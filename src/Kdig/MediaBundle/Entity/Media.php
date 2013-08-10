<?php

namespace Kdig\MediaBundle\Entity;

use Sonata\MediaBundle\Entity\BaseMedia as BaseMedia;

use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * 
 * @ORM\Table
 * @Gedmo\Loggable
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass="Kdig\MediaBundle\Repository\MediaRepository")
 *
 */
class Media extends BaseMedia
{

    /**
     * @var integer $id
     */
    protected $id;
    
    /**
     * @var array
     */
    protected $heritage;    

    /**
    * @ORM\ManyToMany(targetEntity="Kdig\ArchaeologicalBundle\Entity\Site", mappedBy="media", cascade={"persist"})
    */
    private $sites;
    
    /**
    * @ORM\ManyToMany(targetEntity="Kdig\ArchaeologicalBundle\Entity\Area", mappedBy="media", cascade={"persist"})
    */
    private $areas;
    
    /**
    * @ORM\ManyToMany(targetEntity="Kdig\ArchaeologicalBundle\Entity\Us", mappedBy="media", cascade={"persist"})
    */
    private $uss;
    
    /**
    * @ORM\ManyToMany(targetEntity="Kdig\ArchaeologicalBundle\Entity\Prepottery", mappedBy="media", cascade={"persist"})
    */
    private $prepotterys;
    
    /**
    * @ORM\ManyToMany(targetEntity="Kdig\ArchaeologicalBundle\Entity\Preobject", mappedBy="media", cascade={"persist"})
    */
    private $preobjects;
    
    /**
    * @ORM\ManyToMany(targetEntity="Kdig\ArchaeologicalBundle\Entity\Presample", mappedBy="media", cascade={"persist"})
    */
    private $presamples;
    
    /**
    * @ORM\ManyToMany(targetEntity="Kdig\OrientBundle\Entity\Bucket", mappedBy="media", cascade={"persist"})
    */
    private $buckets;
    
    /**
    * @ORM\ManyToMany(targetEntity="Kdig\OrientBundle\Entity\Bucketsheet", mappedBy="media", cascade={"persist"})
    */
    private $bucketsheets;
    
    /**
    * @ORM\ManyToMany(targetEntity="Kdig\OrientBundle\Entity\Pottery", mappedBy="media", cascade={"persist"})
    */
    private $potterys;
    
    /**
    * @ORM\ManyToMany(targetEntity="Kdig\OrientBundle\Entity\Object", mappedBy="media", cascade={"persist"})
    */
    private $objects;
    
    /**
    * @ORM\ManyToMany(targetEntity="Kdig\OrientBundle\Entity\Sample", mappedBy="media", cascade={"persist"})
    */
    private $samples;
    
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
     * Get id
     *
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Get id
     *
     * @return integer $id
     */
    public function setId($id)
    {
    	$this->id = $id;
    }  

    /**
     *
     * This method is used when you want to convert to string an object of
     * this Entity
     * ex: $value = (string)$entity;
     *
     */
    public function __toString()
    {
    	return (string) $this->getName();
    }
    
    /**
     * Set Role
     *
     * @param array $heritage
     */
    public function setHeritage( array $heritage)
    {
    	$this->heritage = array();
    
    	foreach ($heritage as $role) {
    		$this->addRoleInHeritage($role);
    	}
    }
    
    /**
     * Get heritage
     *
     * @return array
     */
    public function getHeritage()
    {
    	return $this->heritage;
    }
    
    /**
     * Adds a role heritage.
     *
     * @param string $role
     */
    public function addRoleInHeritage($role)
    {
    	$role = strtoupper($role);
    
    	if (!in_array($role, $this->heritage, true)) {
    		$this->heritage[] = $role;
    	}
    }    
}