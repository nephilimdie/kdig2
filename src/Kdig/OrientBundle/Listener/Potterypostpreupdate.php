<?php

namespace Kdig\OrientBundle\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Kdig\OrientBundle\Entity\Pottery as Pottery;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class Potterypostpreupdate 
{
    private $container;
 
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
 
    public function postUpdate(LifecycleEventArgs $args) {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();
        $aclProvider = $this->container->get('problematic.acl_manager');
        
        if ($entity instanceof Pottery) {
            $tcode = $entity->getClass()->getNumber()
                    .$entity->getShape()->getNumber()
                    .'-'
                    .$entity->getRim()->getNumber()
                    .$entity->getNeck()->getNumber()
                    .$entity->getWall()->getNumber()
                    .$entity->getUpperwall()->getNumber()
                    .$entity->getLowerwall()->getNumber()
                    .$entity->getBase()->getNumber()
                    .$entity->getHandle()->getNumber()
                    .$entity->getHandleposition()->getNumber()
                    .$entity->getSpout()->getNumber()
                    .$entity->getSpoutposition()->getNumber()
                    .'-'
                    .$entity->getInclusion()->getNumber()
                    .$entity->getInclusionsize()->getNumber()
                    .$entity->getInclusionfrequency()->getNumber();
            $entity->setTcode($tcode);
            $entityManager->persist($entity);
            $entityManager->flush();
            
            //add ACL information
            
            $user = $this->container->get('security.context')->getToken()->getUser();
            if ($user) {
                $aclProvider->addObjectPermission($entity, MaskBuilder::MASK_OWNER, $user);
            }
        }
    }
    
    public function postPersist(LifecycleEventArgs $args) {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();
        if ($entity instanceof Pottery) {
            $tcode = $entity->getClass()->getNumber()
                    .$entity->getShape()->getNumber()
                    .'-'
                    .$entity->getRim()->getNumber()
                    .$entity->getNeck()->getNumber()
                    .$entity->getWall()->getNumber()
                    .$entity->getUpperwall()->getNumber()
                    .$entity->getLowerwall()->getNumber()
                    .$entity->getBase()->getNumber()
                    .$entity->getHandle()->getNumber()
                    .$entity->getHandleposition()->getNumber()
                    .$entity->getSpout()->getNumber()
                    .$entity->getSpoutposition()->getNumber()
                    .'-'
                    .$entity->getInclusion()->getNumber()
                    .$entity->getInclusionsize()->getNumber()
                    .$entity->getInclusionfrequency()->getNumber();
            $entity->setTcode($tcode);
            $entityManager->persist($entity);
            $entityManager->flush();
        }
    }
//    public function prePersist(LifecycleEventArgs $args) {
//        $entity = $args->getEntity();
//        $entityManager = $args->getEntityManager();
//        if ($entity instanceof \Surgeworks\CoreBundle\Entity\ItemsToCollections) {
//            $item_id = $entity->getItemId();
//            $item = $entityManager->getRepository('Surgeworks\CoreBundle\Entity\Item')->find($item_id);
//            $stat_symb = $item->getItemStatus()->getStatusSymbol();
//            if ($stat_symb != 'st_live') {
//                $entity->setStatusId($item->getStatusId());
//            }
//        }
//    }
}