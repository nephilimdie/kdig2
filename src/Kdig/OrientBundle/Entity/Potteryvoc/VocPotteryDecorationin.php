<?php

/**
 * Description of ArchaelogicalBundle 
 *
 * @ author Stefano Bassetto <stefano.bassetto@gmail.com>
 */

namespace Kdig\ArchaelogicalBundle\Entity\Potteryvoc;

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
     * @ORM\ManyToOne(targetEntity="Kdig\ArchaelogicalBundle\Entity\Potteryvoc\VocColor", inversedBy="vocpotdecin" ) 
     */
    protected $color;

    /** 
     * @ORM\ManyToOne(targetEntity="Kdig\ArchaelogicalBundle\Entity\Pottery", inversedBy="potdecorationin" ) 
     */
    protected $pottery;

    /** 
     * @ORM\ManyToOne(targetEntity="Kdig\ArchaelogicalBundle\Entity\Potteryvoc\VocDecorationOption", inversedBy="decorationin" ) 
     */
    protected $decorationoption;
}