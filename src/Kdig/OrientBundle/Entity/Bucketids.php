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

/**
 * @ORM\Entity
 * @ORM\Table(name="bucketids", schema="public")
 * @Gedmo\Loggable
 */
class Bucketids {

    /**
     * @ORM\Id
     * @ORM\Column( type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Gedmo\Versioned
     */
    private $id;
    
    /**
     * @ORM\Column(nullable=true,length=64, type="integer")
     */
    private $oldis;
    
    /**
     * @ORM\OneToOne(targetEntity="Bucket", cascade={"persist"})
     */
    private $newid;
    /**
     * @ORM\Column(nullable=true, name="created", type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private $created;

    /**
     * @ORM\Column(nullable=true, name="updated", type="datetime")
     * @Gedmo\Timestampable(on="update")
     */
    private $updated;

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
     * Set oldis
     *
     * @param integer $oldis
     */
    public function setOldis($oldis)
    {
        $this->oldis = $oldis;
    }

    /**
     * Get oldis
     *
     * @return integer 
     */
    public function getOldis()
    {
        return $this->oldis;
    }

    /**
     * Set created
     *
     * @param datetime $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * Get created
     *
     * @return datetime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param datetime $updated
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    }

    /**
     * Get updated
     *
     * @return datetime 
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set newid
     *
     * @param Kdig\ArchaelogicalBundle\Entity\Bucket $newid
     */
    public function setNewid(\Kdig\ArchaelogicalBundle\Entity\Bucket $newid)
    {
        $this->newid = $newid;
    }

    /**
     * Get newid
     *
     * @return Kdig\ArchaelogicalBundle\Entity\Bucket 
     */
    public function getNewid()
    {
        return $this->newid;
    }
}