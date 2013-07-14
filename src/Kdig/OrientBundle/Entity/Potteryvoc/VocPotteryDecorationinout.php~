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
     * @ORM\ManyToOne(targetEntity="Kdig\OrientBundle\Entity\Potteryvoc\VocColor", inversedBy="vocpotdecinout" ) 
     */
    protected $color;

    /** 
     * @ORM\ManyToOne(targetEntity="Kdig\OrientBundle\Entity\Pottery", inversedBy="potdecorationinout" ) 
     */
    protected $pottery;

    /** 
     * @ORM\ManyToOne(targetEntity="Kdig\OrientBundle\Entity\Potteryvoc\VocDecorationOption", inversedBy="decorationinout" ) 
     */
    protected $decorationoption;
}