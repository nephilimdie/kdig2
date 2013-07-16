<?php
namespace Kdig\OrientBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Security\Core\SecurityContext;

class VocObjClassRepository extends EntityRepository
{
    public function findAjaxValue($value)
    {
        $group = $user->getSlectedgroup();
        
        foreach ($group->getAreas() as $area)
            $areas[]=$area->getId(); 
        
        $ids = array();
        $expr = new \Doctrine\ORM\Query\Expr();
        
        $result = $this->createQueryBuilder('b')
            ->select('b', 'u')
            ->from('KdigArchaeologicalBundle:Us', 'u')
            ->innerJoin('u.area', 'aid','WITH', $expr->in('u.area', $areas))
//            ->add('where', $result->expr()->in('u.area', $areas))
            ->where('u.id = b.us')
            ->getQuery()->getResult();
        
        foreach ($result as $id)
            $ids[]=$id->getId(); 
        
        return $ids;
    }
    
}