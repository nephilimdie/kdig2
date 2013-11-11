<?php
namespace Kdig\OrientBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Security\Core\SecurityContext;

class PotteryRepository extends EntityRepository
{
    public function trovatuttoCazzo() {
        
        return $this->getEntityManager()
            ->createQuery('SELECT p FROM KdigOrientBundle:Pottery p ORDER BY p.tcode ASC')
            ->getResult();
    }
}