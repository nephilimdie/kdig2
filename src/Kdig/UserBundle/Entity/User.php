<?php
/**
 * This file is part of the <User> project.
 * 
 * @category   Kdig_Entities
 * @package    Entity
 * @author Stefano Bassetto <stefano.bassetto.nep@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Kdig\UserBundle\Entity;

use Sonata\UserBundle\Entity\BaseUser as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
//use Kdig\UserBundle\Repository\PermissionRepository;

use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 * @ ORM\Entity
 * (repositoryClass="Kdig\UserBundle\Entity\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks() 
 * 
 * @category   Kdig_Entities
 * @package    Entity
 * 
 * @author Stefano Bassetto <stefano.bassetto.nep@gmail.com>
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     \*/
    protected $id;
    
    /**
     * @ORM\ManyToMany(targetEntity="Kdig\UserBundle\Entity\Group")
     * @ORM\JoinTable(name="fos_user_user_group",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id")}
     * )
     */
    protected $groups;
    
    /**
     * @ORM\ManyToOne(targetEntity="Group", inversedBy="userprofilegroup")
     * @ORM\JoinColumn(nullable=true, name="group_id", referencedColumnName="id")
     */
    protected $slectedgroup;
    
    /**
     * @ORM\ManyToOne(targetEntity="Kdig\ArchaeologicalBundle\Entity\Area", inversedBy="userprofilearea")
     * @ORM\JoinColumn(nullable=true, name="area_id", referencedColumnName="id")
     */
    protected $slectedarea;
    
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
     * Set slectedgroup
     *
     * @param Kdig\UserBundle\Entity\Group $slectedgroup
     */
    public function setSlectedgroup(\Kdig\UserBundle\Entity\Group $slectedgroup)
    {
        $this->slectedgroup = $slectedgroup;
    }

    /**
     * Get slectedgroup
     *
     * @return Kdig\UserBundle\Entity\Group 
     */
    public function getSlectedgroup()
    {
        return $this->slectedgroup;
    }

    /**
     * Set slectedarea
     *
     * @param Kdig\ArchaeologicalBundle\Entity\Area $slectedarea
     */
    public function setSlectedarea(\Kdig\ArchaeologicalBundle\Entity\Area $slectedarea)
    {
        $this->slectedarea = $slectedarea;
    }

    /**
     * Get slectedarea
     *
     * @return Kdig\ArchaeologicalBundle\Entity\Area 
     */
    public function getSlectedarea()
    {
        return $this->slectedarea;
    }
}
