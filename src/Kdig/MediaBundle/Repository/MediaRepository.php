<?php
namespace Kdig\MediaBundle\Repository;

use Doctrine\ORM\EntityRepository;

class MediaRepository extends EntityRepository
{
    public function findAllUseLike($q)
    {   
        $expr = new \Doctrine\ORM\Query\Expr();
        return $result = $this->createQueryBuilder('m')
            ->setParameter('q', '%'.$q.'%')
            ->where('m.name LIKE :q')
            ->getQuery()->getResult();
    }
}