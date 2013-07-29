<?php

namespace Kdig\MediaBundle\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Kdig\OrientBundle\Entity\Bucket as Bucket;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Oneup\UploaderBundle\Event\PostUploadEvent;
use Oneup\UploaderBundle\Event\PostPersistEvent;
use Kdig\MediaBundle\Entity\Media;

class UploadListener
{
    private $container;
 
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function onUpload(PostUploadEvent $event)
    {
        $request = $event->getRequest();
        $file = $event->getFile();
        die(var_dump($file));
        $gallery = $request->get('gallery');

            $mediaClass = $mediaAdmin->getClass();
            /** @var $media \Sonata\MediaBundle\Model\MediaInterface */
            $media = new $mediaClass();


        // added with sonata media
            /** @var $mediaAdmin \Sonata\MediaBundle\Admin\ORM\MediaAdmin */
            $mediaAdmin = $this->get('sonata.media.admin.media');
            /** @var $provider \Sonata\MediaBundle\Provider\MediaProviderInterface */
            $context = $mediaAdmin->getPool()->getDefaultContext();
        $media = new Media();
        $media->setProviderName('sonata.media.provider.file');
            $media->setEnabled(true);
            $media->setName($file->getClientOriginalName());
            $media->setContext($context);
            $media->setBinaryContent($file);
            $provider = $this->get($providerName);
            $path = $provider->generatePublicUrl($media, 'reference');

        $this->container->get('sonata.media.pool')->prePersist($media);
        $em->persist($media);
        $em->flush();
        $this->container->get('sonata.media.pool')->postPersist($media);
        
        $aclProvider = $this->container->get('problematic.acl_manager');
        $user = $this->container->get('security.context')->getToken()->getUser();
        if ($user) {
            $aclProvider->addObjectPermission($media, MaskBuilder::MASK_OWNER, $user);
        }


    }
}