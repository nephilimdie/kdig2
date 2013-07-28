<?php
namespace Kdig\ArchaeologicalBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Security\Core\SecurityContext;

class PresampleRepository extends EntityRepository
{
    public function getmygroupelement($idsbucket)
    {
        $ids = array();
        $expr = new \Doctrine\ORM\Query\Expr();
        $result = $this->createQueryBuilder('p')
            ->setParameter('buckets', $idsbucket)
            ->where($expr->in('p.bucket', ':buckets'))
            //->add('where', ($this->getEntityManager()->createQueryBuilder()->expr()->in('p.bucket', $idsbucket)))
            ->getQuery()->getResult();
          
        foreach ($result as $id)
            $ids[]=$id->getId(); 
        
        return $ids;
    }
    
    public function freeName($bucket) 
    {
        $presigla = $bucket->getName().'/Sample';

        $num = 0;
        $result = $this->createQueryBuilder('b')
            ->select('b', 'u')
            ->from('KdigOrientBundle:Bucket', 'u')
            ->setParameter('bucket', $bucket->getId())
            ->where('u.id = :bucket')
            ->orderBy('b.name', 'ASC')
            ->getQuery()
            ->getResult();
		
        foreach ($result as $str){
            $stringa = str_replace($presigla,'', $str->getName());
            if((int)$stringa >= $num)
                $num = (int)$stringa;
        }
    	return $presigla.((int)$num+1);
    }
}