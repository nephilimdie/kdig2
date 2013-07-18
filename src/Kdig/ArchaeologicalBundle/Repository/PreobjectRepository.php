<?php
namespace Kdig\ArchaeologicalBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Security\Core\SecurityContext;

class PreobjectRepository extends EntityRepository
{   
    public function getmygroupelement($idsbucket)
    { 
        $ids = array();
        $expr = new \Doctrine\ORM\Query\Expr();
        $result = $this->createQueryBuilder('p')
            ->select('p')
            ->where($expr->in('p.bucket', $idsbucket))
            ->getQuery()->getResult();
        
//        die($result->getDQL());
        
        foreach ($result as $id)
            $ids[]=$id->getId(); 
        
        return $ids;
    }
    
    public function freeName($bucket) 
    {
        $i = 0;
        $vect = array('a','b','c','d','e','f','g','h','i','l','m','n','o',
                        'p','q','r','s','t','u','v','z','aa','ab','ac','ad',
            'ae','af','ag','ah','ai','al','am','an','ao','ap','aq','ar','as',
            'at','au','av','az','ba','bb','bc','bd','be','bf','bg','bh','bi',
            'bl','bm','bn','bo','bp','bq','br','bs','bt','bu','bv','bz','ca',
            'cb','cc','cd','ce','cf','cg','ch','ci','cl','cm','cn','co','cp',
            'cq','cr','cs','ct','cu','cv','cz','da','db','dc','dd','de','df',
            'dg','dh','di','dl','dm','dn','do','dp','dq','dr','ds','dt','du',
            'dv','dz','ea','eb','ec','ed','ee','ef','eg','eh','ei','el','em',
            'en','eo','ep','eq','er','es','et','eu','ev','ez');

        $presigla = $bucket->getName().'/';
        $newvec = array();
        
        $result = $this->createQueryBuilder('b')
            ->select('b', 'u')
            ->from('KdigArchaelogicalBundle:Bucket', 'u')
            ->setParameter('bucket', $bucket->getId())
            ->where('u.id = :bucket')
            ->orderBy('b.name', 'ASC')
            ->getQuery()
            ->getResult();

        $let = $vect[0];
        $newvec = array();
        foreach ($result as $i => $str){
            $stringa  = str_replace($presigla,'', $str->getName());
            $newvec[] = $stringa;
        }
        $count = count( $vect );

        for ( $i = 0; $i < $count; $i++ )
        {
            if(!in_array($vect[$i], $newvec)) {
                $let = $vect[$i];
            return ($presigla.$let);
            }
        }
        return $stringa = $presigla.$numC;
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
            $entity = new \Kdig\OrientBundle\Entity\Preobject();
            $entity -> setName($name);
            $em->persist($entity);
            $em->flush();
            return $entity;
        } else {
            return $entity = $this->findOneBy(array('name'=>$name));
        }
    }
}