<?php

/**
 * Description of ArchaelogicalBundle 
 *
 * @ author Stefano Bassetto <stefano.bassetto@gmail.com>
 */

namespace Kdig\OrientBundle\Entity\Potteryvoc;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

use Symfony\Component\Validator\Constraints as Assert;
use APY\DataGridBundle\Grid\Mapping as GRID;

/**
 * @ORM\Entity
 * @ORM\Table(name="pottery_decorationinout", schema="public")
 * @Gedmo\Loggable
 */
class VocPotteryDecorationinout {
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Gedmo\Versioned
     */
    private $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Kdig\OrientBundle\Entity\Potteryvoc\VocColor", inversedBy="vocpotdecinout", orphanRemoval=true, cascade={"remove"} ) 
     */
    protected $color;

    /** 
     * @ORM\ManyToOne(targetEntity="Kdig\OrientBundle\Entity\Pottery", inversedBy="potdecorationinout", orphanRemoval=true, cascade={"remove"} ) 
     */
    protected $pottery;

    /** 
     * @ORM\ManyToOne(targetEntity="Kdig\OrientBundle\Entity\Potteryvoc\VocDecorationOption", inversedBy="decorationinout", orphanRemoval=true, cascade={"remove"} ) 
     */
    protected $decorationoption;

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
     * Set color
     *
     * @param \Kdig\OrientBundle\Entity\Potteryvoc\VocColor $color
     * @return VocPotteryDecorationinout
     */
    public function setColor(\Kdig\OrientBundle\Entity\Potteryvoc\VocColor $color = null)
    {
        $this->color = $color;
    
        return $this;
    }

    /**
     * Get color
     *
     * @return \Kdig\OrientBundle\Entity\Potteryvoc\VocColor 
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set pottery
     *
     * @param \Kdig\OrientBundle\Entity\Pottery $pottery
     * @return VocPotteryDecorationinout
     */
    public function setPottery(\Kdig\OrientBundle\Entity\Pottery $pottery = null)
    {
        $this->pottery = $pottery;
    
        return $this;
    }

    /**
     * Get pottery
     *
     * @return \Kdig\OrientBundle\Entity\Pottery 
     */
    public function getPottery()
    {
        return $this->pottery;
    }

    /**
     * Set decorationoption
     *
     * @param \Kdig\OrientBundle\Entity\Potteryvoc\VocDecorationOption $decorationoption
     * @return VocPotteryDecorationinout
     */
    public function setDecorationoption(\Kdig\OrientBundle\Entity\Potteryvoc\VocDecorationOption $decorationoption = null)
    {
        $this->decorationoption = $decorationoption;
    
        return $this;
    }

    /**
     * Get decorationoption
     *
     * @return \Kdig\OrientBundle\Entity\Potteryvoc\VocDecorationOption 
     */
    public function getDecorationoption()
    {
        return $this->decorationoption;
    }
    
    public function __tostring() 
    {
        return (string)$this->getDecorationoption().' - '.$this->getColor();
    }
}