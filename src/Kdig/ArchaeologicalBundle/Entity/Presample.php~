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

/**
 * @ORM\Entity
 * @ORM\Table(name="pre_sample", schema="public")
 * @ORM\Entity(repositoryClass="Kdig\ArchaeologicalBundle\Repository\PresampleRepository")
 * @Gedmo\Loggable
 * @GRID\Source(columns="id, bucket.us.area.name, bucket.us.typeus.name, bucket.us.name, bucket.name, name, isActive, isDelete, isPublic, created")
*/
class Presample {
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Gedmo\Versioned
     * @GRID\Column(title="ID", size="50",visible=false)
     */
    private $id;
    
    /**
     * @Gedmo\Versioned
     * @ORM\Column(nullable=true, length=64, type="string")
     * @Assert\NotBlank()
     * @GRID\Column(size="40", title="Name")
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
     * @GRID\Column(type="date", size="40", filter="select")
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
     * @GRID\Column(visible=false)
     */
    private $isActive=true;
    
    /**
     * @Gedmo\Versioned
     * @ORM\Column(nullable=true, name="is_public", type="boolean")
     * @GRID\Column(visible=false)
     */
    private $isPublic=false;
    
    /**
     * @Gedmo\Versioned
     * @ORM\Column(nullable=true, name="is_delete", type="boolean")
     * @GRID\Column(visible=false)
     */
    private $isDelete=false;
    
    /**
     * @ORM\ManyToOne(targetEntity="Bucket", inversedBy="presamples", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true, name="bucket_id", referencedColumnName="id", onDelete="SET NULL")
     * @GRID\Column(field="bucket.name", title="Bucket")
     * @GRID\Column(field="bucket.us.name", title="Locus", size="40")
     * @GRID\Column(field="bucket.us.typeus.name", title="Type Locus", filter="select", size="40")
     * @GRID\Column(field="bucket.us.area.name", title="Area", filter="select", size="40")
     */
    private $bucket;
    
    /**
     *
     * @ORM\ManyToMany(targetEntity="Media", inversedBy="presamples", cascade={"persist"})
     * @ORM\JoinTable(name="presample_media",
     *   joinColumns={@ORM\JoinColumn(nullable=true, name="presample_id", referencedColumnName="id", onDelete="SET NULL")},
     *   inverseJoinColumns={@ORM\JoinColumn(nullable=true, name="media_id", referencedColumnName="id", onDelete="SET NULL")}
     * )
     */
    private $media;

    /**
     * @ORM\OneToOne(targetEntity="Sample", inversedBy="presample", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true, name="sample_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $sample;
    
}