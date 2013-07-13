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
 * @ORM\Table(name="pottery_surfacetratin", schema="public")
 * @Gedmo\Loggable
 */
class VocPotterySurfacetratin {
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Gedmo\Versioned
     */
    private $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Kdig\OrientBundle\Entity\Potteryvoc\VocColor", inversedBy="pottery_surfacetratin" ) 
     */
    protected $color;

    /** @ORM\ManyToOne(targetEntity="Kdig\OrientBundle\Entity\Pottery", inversedBy="surfacetratin" ) */
    protected $pottery;

    /** @ORM\ManyToOne(targetEntity="Kdig\OrientBundle\Entity\Potteryvoc\VocSurfaceTratOption", inversedBy="surfacein" ) */
    protected $vocsurfacetratoption;
}