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

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Kdig\UserBundle\Repository\PermissionRepository;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 * @ORM\Entity(repositoryClass="Kdig\UserBundle\Entity\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks() 
 * 
 * @category   Kdig_Entities
 * @package    Entity
 * 
 * @author Stefano Bassetto <stefano.bassetto.nep@gmail.com>
 */
class User extends BaseUser
{
	const ROLE_DEFAULT = 'ROLE_ALLOWED_TO_SWITCH';
	
    /**
     * @var bigint $id
     * 
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
	protected $id;
	
	/**
	 * @var string $name
	 *
	 * @ORM\Column(name="name", type="string", nullable = true)
	 */
	protected $name;
		
	/**
	 * @var string $nickname
	 *
	 * @ORM\Column(name="nickname", type="string", nullable = true)
	 */
	protected $nickname;	
	

 	/**
     * @ORM\ManyToMany(targetEntity="Kdig\UserBundle\Entity\Group")
     * @ORM\JoinTable(name="fos_user_group",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id")}
     * )
     */
    protected $groups;
     
    
    /**
     * @var array
     * @ORM\Column(type="array")
     */
    protected $permissions;    
    
    /**
     * @var \DateTime
     */
    public $expiresAt;
    
    /**
     * @var \DateTime
     */
    public $credentialsExpireAt;    
    
    /**
     * @var datetime $created_at
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     * @Gedmo\Timestampable(on="create")
     */
    protected $created_at;
    
    /**
     * @ORM\Column(name="updated", type="datetime")
     * @Gedmo\Timestampable(on="update")
     */
    private $updated;
    

    public function __construct()
    {
    	parent::__construct();
    	$this->groups		= new \Doctrine\Common\Collections\ArrayCollection();
    }    
    
    /**
     *
     * This method is used when you want to convert to string an object of
     * this Entity
     * ex: $value = (string)$entity;
     *
     */
    public function __toString() {
    	return (string) $this->username;
    }    

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
     * Add groups
     *
     * @param \Kdig\UserBundle\Entity\Group $groups
     */
    public function addGroupUser(\Kdig\UserBundle\Entity\Group $groups)
    {
        $this->groups[] = $groups;
    }
	
    /**
     * Get groups
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getGroupsUser()
    {
        return $this->groups;
    }
    
    /**
     * Set permissions
     *
     * @param array $permissions
     */
    public function setPermissions(array $permissions)
    {
    	$this->permissions = array();
    
    	foreach ($permissions as $permission) {
    		$this->addPermission($permission);
    	}
    }
    
    /**
     * Get permissions
     *
     * @return array
     */
    public function getPermissions()
    {
    	$permissions = $this->permissions;
    
    	// we need to make sure to have at least one role
    	$permissions[] = PermissionRepository::ShowDefaultPermission();
    
    	return array_unique($permissions);
    }   

    /**
     * Adds a permission to the user.
     *
     * @param string $permission
     */
    public function addPermission($permission)
    {
    	$permission = strtoupper($permission);
    
    	if (!in_array($permission, $this->permissions, true)) {
    		$this->permissions[] = $permission;
    	}
    }  

    /**
     * Adds a role to the user.
     *
     * @param string $role
     */
    public function addRole($role)
    {
    	$role = strtoupper($role);
    	if ($role === static::ROLE_DEFAULT) {
    		return;
    	}
    
    	if (!in_array($role, $this->roles, true)) {
    		$this->roles[] = $role;
    	}
    }

    /**
     * Returns the user roles
     *
     * Implements SecurityUserInterface
     *
     * @return array The roles
     */
    public function getRoles()
    {
    	$roles = $this->roles;
    
    	foreach ($this->getGroups() as $group) {
    		$roles = array_merge($roles, $group->getRoles());
    	}
    	
    	// we need to make sure to have at least one role
    	$roles[] = static::ROLE_DEFAULT;
    	
    	return array_unique($roles);
    }
    
    /**
     * Set name
     *
     * @param text $name
     */
    public function setName($name)
    {
    	$this->name = $name;
    }
    
    /**
     * Get name
     *
     * @return text
     */
    public function getName()
    {
    	return $this->name;
    }
    
    /**
     * Set nickname
     *
     * @param text $nickname
     */
    public function setNickname($nickname)
    {
    	$this->nickname = $nickname;
    }
    
    /**
     * Get nickname
     *
     * @return text
     */
    public function getNickname()
    {
    	return $this->nickname;
    }
    
    /**
     * get Updated
     *
     * @param datetime $updated
     */
    public function getUpdated()
    {
        return $this->updated;
    }
    
    /**
     * Get created_at
     *
     * @return datetime
     */
    public function getCreatedAt()
    {
    	return $this->created_at;
    }    
}