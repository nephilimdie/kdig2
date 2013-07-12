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
    public function freeName($sigla, $user) 
    {
        
        $area = $user->getSlectedarea();
        $Frombucket = $area->getFromrefus();
        $Tobucket = $area->getTorefus();
        $numdef = $Frombucket;  
        
        $presigla = $sigla;
        
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
}