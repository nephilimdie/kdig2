<?php
namespace Kdig\ArchaeologicalBundle\Repository;

use Doctrine\ORM\EntityRepository;

class UsRepository extends EntityRepository
{
    public function findAreaElement($areas)
    {
        $result = $this->createQueryBuilder('b')
            ->select('b')
            ->setParameter('area', $area)
            ->whereIn('b.area = :area')
            ->orderBy('b.name', 'ASC')
            ->getQuery()
            ->getResult();
    }
    public function freeName($presigla, $area) 
    {
        //$area = $user->getSlectedarea();
        $Frombucket = $area->getFromrefus();
        
        $Tobucket = $area->getTorefus();
        $numdef = $Frombucket;  
        
        $newvec = array();
        
        $result = $this->createQueryBuilder('b')
            ->select('b')
            ->setParameter('area', $area)
            ->where('b.area = :area')
            ->orderBy('b.name', 'ASC') 
            ->getQuery()
            ->getResult(); 

        foreach ($result as $str){
            $stringa = str_replace($presigla,'', $str->getName());
            $newvec[] = (int)$stringa;
        }

        $count = count($newvec);
        $numC = (int)$Frombucket;

        for ( $i = 0; $i < $count; $i++ )
        {
            if(!in_array($numC, $newvec)) {
                $let = $numC;
                return (str_pad($let, 4 , "0000", STR_PAD_LEFT));
            }
            $numC++;
        }

        return str_pad($numC, 4 , "0000", STR_PAD_LEFT);
    }
    
    private function isUnusedName($name) {        
        $result = $this->createQueryBuilder('u')
            ->select('u')
            ->where('u.name = :name')
            ->setParameter('name', $name)
            ->getQuery();

        $res = $result->getResult();
        return empty($res);
    }
    
    public function checkAndAdd($name, $area, $site, $type){
        if($this->isUnusedMaterial($name)) {
            //createnew
            $em = $this->getEntityManager();
            $entity = new \Kdig\ArchaeologicalBundle\Entity\Us();
            $entity->setName($name);
            $entity->setArea($area);
            $entity->setSite($site);
            $entity->setTypeus($type);
            $entity->setIsPublic(false);
            $entity->setIsActive(true);
            $entity->setIsDelete(false);
            $em->persist($entity);
            $em->flush();
            return $entity;
        } else {
            return $entity = $this->findOneBy(array('name'=>$name));
        }
    }
}