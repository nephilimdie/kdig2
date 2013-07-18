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
    
    private function isUnusedMaterial($name) {        
        $result = $this->createQueryBuilder('u')
            ->select('u')
            ->where('u.name = :name')
            ->setParameter('name', $name)
            ->getQuery();

        $res = $result->getResult();
        return empty($res);
    }
    
    public function checkAndAdd($name){
        if($this->isUnusedMaterial($name)) {
            //createnew
            $em = $this->getEntityManager();
            $entity = new \Kdig\OrientBundle\Entity\Object();
            $entity -> setName($name);
            $em->persist($entity);
            $em->flush();
            return $entity;
        } else {
            return $entity = $this->findOneBy(array('name'=>$name));
        }
    }
}