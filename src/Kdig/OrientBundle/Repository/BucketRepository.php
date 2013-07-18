<?php
namespace Kdig\OrientBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Security\Core\SecurityContext;

class BucketRepository extends EntityRepository
{
    public function getmygroupelement($user)
    {
        $group = $user->getSlectedgroup();
        //$areaid = getSlectedarea();
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
    public function freeName($sigla, $user) 
    {
        $area = $user->getSlectedarea();
        $Frombucket = $area->getFromrefbucket();
        $siteid = 1;//$sigla->getId();
        
        $Tobucket = $area->getTorefbucket();
        $numdef = $Frombucket;  
        
        $presigla = $sigla->getSigla().'P.';

        $newvec = array();
        
        $result = $this->createQueryBuilder('b')
            ->select('b', 'u')
            ->from('KdigArchaeologicalBundle:Us', 'u')
            ->setParameter('area', $area)
                // da cambiare con quello attivo e non con 1
            ->setParameter('siteid', $siteid)
            ->innerJoin('u.area', 'aid','WITH', 'aid = :area' )
            ->where('u.id = b.us')
            ->andWhere('u.site = :siteid')
            ->orderBy('b.name', 'ASC')
            ->getQuery()->getResult();
        
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
                return ($presigla.str_pad($let, 4 , "0000", STR_PAD_LEFT));
                }
                $numC++;
            }

        return $stringa = $presigla.str_pad($numC, 4 , "0000", STR_PAD_LEFT);
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
            $entity = new \Kdig\OrientBundle\Entity\Bucket();
            $entity -> setName($name);
            $em->persist($entity);
            $em->flush();
            return $entity;
        } else {
            return $entity = $this->findOneBy(array('name'=>$name));
        }
    }
    
}