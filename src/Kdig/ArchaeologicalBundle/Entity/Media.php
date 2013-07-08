<?php

/**
 * Description of ArchaelogicalBundle 
 *
 * @ author Stefano Bassetto <stefano.bassetto@gmail.com>
 */

namespace Kdig\ArchaeologicalBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

use Symfony\Component\Validator\Constraints as Assert;
use APY\DataGridBundle\Grid\Mapping as GRID;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use Symfony\Component\HttpKernel\Kernel;

/**
 * @ORM\Entity
 * @ORM\Table(name="media", schema="public")
 * @ ORM\Entity(repositoryClass="Kdig\ArchaelogicalBundle\Repository\MediaRepository")
 * @Gedmo\Loggable
 * @ORM\HasLifecycleCallbacks
 */
class Media {
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Gedmo\Versioned
     */
    private $id;
    
    /**
     * @Assert\File(maxSize="200000000")
     * @validation:File( 
     *     maxSize = "200M"
     * ) 
     */
    public $file;

    /**
     * @ORM\Column(type="string", length=255)
     */
    public $mime;

    /**
     * @ORM\Column(type="string", length=255)
     */
    public $size;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public $path;
    
    /**
     * @Gedmo\Versioned
     * @ORM\Column(nullable=true, length=64, type="string")
     * 
     */
    private $name;
    
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
    
    private $selectedarea;
    /**
    * @ORM\ManyToMany(targetEntity="Site", mappedBy="media", cascade={"persist"})
    */
    private $sites;
    
    /**
    * @ORM\ManyToMany(targetEntity="Area", mappedBy="media", cascade={"persist"})
    */
    private $areas;
    
    /**
    * @ORM\ManyToMany(targetEntity="Us", mappedBy="media", cascade={"persist"})
    */
    private $uss;
    
    /**
    * @ORM\ManyToMany(targetEntity="Bucket", mappedBy="media", cascade={"persist"})
    */
    private $buckets;
    
    /**
    * @ORM\ManyToMany(targetEntity="Bucketsheet", mappedBy="media", cascade={"persist"})
    */
    private $bucketsheets;
    
    /**
    * @ORM\ManyToMany(targetEntity="Prepottery", mappedBy="media", cascade={"persist"})
    */
    private $prepotterys;
    
    /**
    * @ORM\ManyToMany(targetEntity="Preobject", mappedBy="media", cascade={"persist"})
    */
    private $preobjects;
    
    /**
    * @ORM\ManyToMany(targetEntity="Presample", mappedBy="media", cascade={"persist"})
    */
    private $presamples;
    
    /**
    * @ORM\ManyToMany(targetEntity="Pottery", mappedBy="media", cascade={"persist"})
    */
    private $potterys;
    
    /**
    * @ORM\ManyToMany(targetEntity="Object", mappedBy="media", cascade={"persist"})
    */
    private $objects;
    
    /**
    * @ORM\ManyToMany(targetEntity="Sample", mappedBy="media", cascade={"persist"})
    */
    private $samples;
    
}