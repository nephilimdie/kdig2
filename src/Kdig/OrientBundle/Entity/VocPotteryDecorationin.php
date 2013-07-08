<?php

/**
 * Description of ArchaelogicalBundle 
 *
 * @ author Stefano Bassetto <stefano.bassetto@gmail.com>
 */

namespace Kdig\ArchaelogicalBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

use Symfony\Component\Validator\Constraints as Assert;
use APY\DataGridBundle\Grid\Mapping as GRID;

/**
 * @ORM\Entity
 * @ORM\Table(name="pottery_decorationin", schema="public")
 * @Gedmo\Loggable
 */
class VocPotteryDecorationin {
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Gedmo\Versioned
     */
    private $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="VocColor", inversedBy="vocpotdecin" ) 
     */
    protected $color;

    /** 
     * @ORM\ManyToOne(targetEntity="Pottery", inversedBy="potdecorationin" ) 
     */
    protected $pottery;

    /** 
     * @ORM\ManyToOne(targetEntity="VocDecorationOption", inversedBy="decorationin" ) 
     */
    protected $decorationoption;

    public function __tostring() 
    {
        return $this->getColor().' '.$this->getDecorationoption();
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
     * Set color
     *
     * @param Kdig\ArchaelogicalBundle\Entity\VocColor $color
     */
    public function setColor(\Kdig\ArchaelogicalBundle\Entity\VocColor $color)
    {
        $this->color = $color;
    }

    /**
     * Get color
     *
     * @return Kdig\ArchaelogicalBundle\Entity\VocColor 
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set pottery
     *
     * @param Kdig\ArchaelogicalBundle\Entity\Pottery $pottery
     */
    public function setPottery($pottery)
    {
        $this->pottery = $pottery;
    }

    /**
     * Get pottery
     *
     * @return Kdig\ArchaelogicalBundle\Entity\Pottery 
     */
    public function getPottery()
    {
        return $this->pottery;
    }

    /**
     * Set decorationoption
     *
     * @param Kdig\ArchaelogicalBundle\Entity\VocDecorationOption $decorationoption
     */
    public function setDecorationoption(\Kdig\ArchaelogicalBundle\Entity\VocDecorationOption $decorationoption)
    {
        $this->decorationoption = $decorationoption;
    }

    /**
     * Get decorationoption
     *
     * @return Kdig\ArchaelogicalBundle\Entity\VocDecorationOption 
     */
    public function getDecorationoption()
    {
        return $this->decorationoption;
    }
}