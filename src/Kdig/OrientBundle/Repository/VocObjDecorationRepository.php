<?php
namespace Kdig\OrientBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Security\Core\SecurityContext;

class VocObjDecorationRepository extends EntityRepository
{
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
            $entity = new \Kdig\OrientBundle\Entity\Objectvoc\VocObjDecoration();
            $entity -> setName($name);
            $em->persist($entity);
            $em->flush();
            return $entity;
        } else {
            return $entity = $this->findOneBy(array('name'=>$name));
        }
    }
}