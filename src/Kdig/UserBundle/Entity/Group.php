<?php

namespace Kdig\UserBundle\Entity;

use Sonata\UserBundle\Entity\BaseGroup as BaseGroup;
use Doctrine\ORM\Mapping as ORM;

use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_group")
 * 
 * @category   Kdig_Entities
 * @package    Entity
 * 
 * @author Etienne de Longeaux <etienne.delongeaux@gmail.com>
 */
class Group extends BaseGroup
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\generatedValue(strategy="AUTO")
     */
     protected $id;
     
    /**
     * @Gedmo\Translatable
     * @ORM\Column(length=64)
     */
    private $title;

    /**
     * @ORM\ManyToMany(targetEntity="Kdig\ArchaeologicalBundle\Entity\Area", mappedBy="groups", cascade={"persist"})
     */ 
   private $areas;
    /**
     * @ORM\OneToMany(targetEntity="Kdig\UserBundle\Entity\User", mappedBy="slectedgroup", cascade={"persist"})
     */
    private $userprofilegroup;
    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;
   
     
     /**
      * @var boolean $enabled
      *
      * @ORM\Column(name="enabled", type="boolean", nullable=true)
      */
     protected $enabled;

     public function __construct($name, $roles = array())
     {
     	parent::__construct($name, $roles);
     	
     	$this->setCreatedAt(new \DateTime());
     	$this->setUpdatedAt(new \DateTime());
     }
     
    /**
     * 
     * This method is used when you want to convert to string an object of
     * this Entity
     * ex: $value = (string)$entity;
     * 
     */    
    public function __toString() {
    	return (string) $this->name;
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
    
    public function getCreated()
    {
        return $this->created;
    }

    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }

    /**
     * Get enabled
     *
     * @return boolean 
     */
    public function getEnabled()
    {
        return $this->enabled;
    }
    
}
