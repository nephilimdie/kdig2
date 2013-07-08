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
 * @ORM\Table(name="pottery_surfacetratout", schema="public")
 * @Gedmo\Loggable
 */
class VocPotterySurfacetratout {
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Gedmo\Versioned
     */
    private $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="VocColor", inversedBy="pottery_surfacetratout" ) 
     */
    protected $color;

    /** @ORM\ManyToOne(targetEntity="Pottery", inversedBy="surfacetratout" ) */
    protected $pottery;

    /** @ORM\ManyToOne(targetEntity="VocSurfaceTratOption", inversedBy="surfaceout" ) */
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
    public function setPottery(\Kdig\ArchaelogicalBundle\Entity\Pottery $pottery)
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
     * Set vocsurfacetratoption
     *
     * @param Kdig\ArchaelogicalBundle\Entity\VocSurfaceTratOption $vocsurfacetratoption
     */
    public function setVocsurfacetratoption(\Kdig\ArchaelogicalBundle\Entity\VocSurfaceTratOption $vocsurfacetratoption)
    {
        $this->vocsurfacetratoption = $vocsurfacetratoption;
    }

    /**
     * Get vocsurfacetratoption
     *
     * @return Kdig\ArchaelogicalBundle\Entity\VocSurfaceTratOption 
     */
    public function getVocsurfacetratoption()
    {
        return $this->vocsurfacetratoption;
    }
}