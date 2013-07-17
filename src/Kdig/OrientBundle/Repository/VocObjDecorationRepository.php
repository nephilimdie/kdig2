<?php
namespace Kdig\OrientBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Security\Core\SecurityContext;

class VocObjDecorationRepository extends EntityRepository
{
    private function isUnusedMaterial($name) {        
        $result = $this->createQueryBuilder('u')
            ->select('u')
            ->from('KdigOrientBundle:Objectvoc\VocObjDecoration', 'u')
            ->where('u.name = :name')
            ->setParameter('name', $name)
            ->createQuery();

        $res = $result->getResult();
        return empty($res);
    }
    public function checkElement($name){
        if($this->isUnusedMaterial($name)) {
            //createnew
            $em = $this->getDoctrine()->getEntityManager();
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