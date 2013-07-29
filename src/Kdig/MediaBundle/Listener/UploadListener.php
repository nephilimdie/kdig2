<?php

namespace Kdig\MediaBundle\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Kdig\OrientBundle\Entity\Bucket as Bucket;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Oneup\UploaderBundle\Event\PostPersistEvent;
use Kdig\MediaBundle\Entity\Media;

class UploadListener
{
    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function onUpload(PostPersistEvent $event)
    {
        $request = $event->getRequest();
        $gallery = $request->get('gallery');
        
        // added with sonata media
        $media = new Media();
        $media->setProviderName('sonata.media.provider.youtube');
        $media->setBinaryContent('an0dymdMo70');
        $media->setUser($em->merge($this->getReference('user_one')));
        //$media->setName('test');

        $this->container->get('sonata.media.pool')->prePersist($media);
        $em->persist($media);
        $em->flush();
        $this->container->get('sonata.media.pool')->postPersist($media);


    }
}