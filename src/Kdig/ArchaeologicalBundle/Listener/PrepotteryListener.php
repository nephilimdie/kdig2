<?php
namespace Kdig\ArchaeologicalBundle\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Kdig\ArchaeologicalBundle\Entity\Prepottery as Prepottery;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class PrepotteryListener 
{
    private $container;
 
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
 
    public function postUpdate(LifecycleEventArgs $args) {
        $entity = $args->getEntity();
//        $entityManager = $args->getEntityManager();
        $aclProvider = $this->container->get('problematic.acl_manager');
        
        if ($entity instanceof Prepottery) {
            //add ACL information
            $user = $this->container->get('security.context')->getToken()->getUser();
            if ($user) {
                $aclProvider->addObjectPermission($entity, MaskBuilder::MASK_OWNER, $user);
            }
        }
    }
    
    public function postPersist(LifecycleEventArgs $args) {}
}