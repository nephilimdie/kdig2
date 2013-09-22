<?php
namespace Kdig\OrientBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Security\Core\SecurityContext;

class PotteryRepository extends EntityRepository
{
    public function trovatuttoCazzo() {
        $result = $this->createQueryBuilder('b')
            ->select('b')
            ->getQuery()
            ->getResult();
    }
}