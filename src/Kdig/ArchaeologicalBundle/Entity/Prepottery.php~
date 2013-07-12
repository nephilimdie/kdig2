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
// DON'T forget this use statement!!!
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="pre_pottery", schema="public")
 * @UniqueEntity("name")
 * @ORM\Entity(repositoryClass="Kdig\ArchaeologicalBundle\Repository\PrepotteryRepository")
 * @Gedmo\Loggable
 * @GRID\Source(columns="id, bucket.us.area.name, bucket.us.typeus.name, bucket.us.name, bucket.name, name, isActive, isDelete, isPublic, created")
 */
class Prepottery {
    
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
     * @GRID\Column(size="40", title="Name", unique=true)
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
     * @ ORM\ManyToOne(targetEntity="Bucket", inversedBy="prepotterys", cascade={"persist"})
     * @ ORM\JoinColumn(nullable=true, name="bucket_id", referencedColumnName="id", onDelete="SET NULL")
     * @ GRID\Column(field="bucket.name", title="Bucket")
     * @ GRID\Column(field="bucket.us.name", title="Locus", size="40")
     * @ GRID\Column(field="bucket.us.typeus.name", title="Type Locus", filter="select", size="40")
     * @ GRID\Column(field="bucket.us.area.name", title="Area", filter="select", size="40")
     */
//    private $bucket;
    
    /**
     *
     * @ORM\ManyToMany(targetEntity="Kdig\MediaBundle\Entity\Media", inversedBy="prepotterys", cascade={"persist"})
     * @ORM\JoinTable(name="prepottery_media",
     *   joinColumns={@ORM\JoinColumn(nullable=true, name="prepottery_id", referencedColumnName="id", onDelete="SET NULL")},
     *   inverseJoinColumns={@ORM\JoinColumn(nullable=true, name="media_id", referencedColumnName="id", onDelete="SET NULL")}
     * )
     */
    private $media;

    /**
     * @ ORM\OneToOne(targetEntity="Pottery", inversedBy="prepottery", cascade={"persist"})
     * @ ORM\JoinColumn(nullable=true, name="pottery_id", referencedColumnName="id", onDelete="CASCADE")
     */
//    private $pottery;
    
}