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
 * @ORM\Table(name="pottery_surfacetratinout", schema="public")
 * @Gedmo\Loggable
 */
class VocPotterySurfacetratinout {
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Gedmo\Versioned
     */
    private $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Kdig\OrientBundle\Entity\Potteryvoc\VocColor", inversedBy="pottery_surfacetratinout", cascade={"remove"} ) 
     */
    protected $color;

    /** @ORM\ManyToOne(targetEntity="Kdig\OrientBundle\Entity\Pottery", inversedBy="surfacetratinout", cascade={"remove"} ) */
    protected $pottery;

    /** @ORM\ManyToOne(targetEntity="Kdig\OrientBundle\Entity\Potteryvoc\VocSurfaceTratOption", inversedBy="surfaceinout", cascade={"remove"} ) */
    protected $vocsurfacetratoption;

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
     * @return VocPotterySurfacetratinout
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
     * @return VocPotterySurfacetratinout
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
     * Set vocsurfacetratoption
     *
     * @param \Kdig\OrientBundle\Entity\Potteryvoc\VocSurfaceTratOption $vocsurfacetratoption
     * @return VocPotterySurfacetratinout
     */
    public function setVocsurfacetratoption(\Kdig\OrientBundle\Entity\Potteryvoc\VocSurfaceTratOption $vocsurfacetratoption = null)
    {
        $this->vocsurfacetratoption = $vocsurfacetratoption;
    
        return $this;
    }

    /**
     * Get vocsurfacetratoption
     *
     * @return \Kdig\OrientBundle\Entity\Potteryvoc\VocSurfaceTratOption 
     */
    public function getVocsurfacetratoption()
    {
        return $this->vocsurfacetratoption;
    }
    
    public function __tostring() 
    {
        return (string)$this->getVocsurfacetratoption().' - '.$this->getColor();
    }
}