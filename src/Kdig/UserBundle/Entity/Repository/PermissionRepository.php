<?php
/**
 * This file is part of the <User> project.
 *
 * @category   Kdig_Repositories
 * @package    Repository
 * @author Stefano Bassetto <stefano.bassetto.nep@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Kdig\UserBundle\Repository;

use Doctrine\ORM\EntityRepository;
//use Kdig\TranslationBundle\Repository\TranslationRepository;

/**
 * Permission Repository
 * 
 * @category   Kdig_Repositories
 * @package    Repository
 *
 * @author Stefano Bassetto <stefano.bassetto.nep@gmail.com>
 */
class PermissionRepository 
//extends TranslationRepository
{
	const PERMISSION_DEFAULT 		= 'VIEW';

	public static function ShowDefaultPermission()
	{
		return self::PERMISSION_DEFAULT;
	}

	public function getAvailablePermissions()
	{
		$query = $this->createQueryBuilder('p')
		->select('p.name')
		->where('p.enabled = :enabled')
		->setParameter('enabled', 1);
		
		return $query->getQuery()->getResult();		
	}	
}