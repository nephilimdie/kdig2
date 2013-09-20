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
    
    private function isUnusedMaterial($number) {
        $result = $this->createQueryBuilder('u')
            ->select('u')
            ->where('u.number = :number')
            ->setParameter('number', $number)
            ->getQuery();

        $res = $result->getResult();
        return empty($res);
    }
    public function checkVersion($num, $versione) {
        
        $result = $this->createQueryBuilder('u')
            ->select('u')
            ->where('u.number = :number')
            ->where('u.version < :versione')
            ->setParameter('number', $num)
            ->setParameter('versione', $versione)
            ->getQuery();

        $res = $result->getResult();
        return empty($res);
    }
    
    public function checkAndAdd($num, $weight, $fragments, $height, $lenght, $width, $thickness, $diameter, $perf, $description, 
                    $material,
                    $decoration,
                    $preservation,
                    $technique,
                    $type,
                    $class,
                    $preObject
            ) {
        if($this->isUnusedMaterial($num)) {
            //createnew
            $em = $this->getEntityManager();
            $entity = new \Kdig\OrientBundle\Entity\Object();
            
            $entity ->setNumber($num);
            $entity ->setWeight($weight);
            $entity ->setFragments($fragments);
            $entity ->setHeight($height);
            $entity ->setLenght($lenght);
            $entity ->setWidth($width);
            $entity ->setThickness($thickness);
            $entity ->setDiameter($diameter);
            $entity ->setPerforationdiameter($perf);
            $entity ->setRemarks($description);
            $entity->setMaterial($material);
            $entity->setDecoration($decoration);
            $entity->setPreservation($preservation);
            $entity->setTechnique($technique);
            $entity->setType($type);
            $entity->setClass($class);
            $entity ->setPreobject($preObject);
            
            $em->persist($entity);
            $em->flush();
            return $entity;
        } else {
            return $entity = $this->findOneBy(array('number'=>$num));
        }
    }
}