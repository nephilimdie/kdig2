<?php

namespace Kdig\OrientBundle\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Kdig\OrientBundle\Entity\Sample as Sample;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;

class SampleListener 
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
        
        if ($entity instanceof Sample) {
            //add ACL information
            $user = $this->container->get('security.context')->getToken()->getUser();
            if ($user) {
                $aclProvider->addObjectPermission($entity, MaskBuilder::MASK_OWNER, $user);
            }
        }
    }
    
    public function postPersist(LifecycleEventArgs $args) {
    }
}