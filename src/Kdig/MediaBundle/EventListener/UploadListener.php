<?php

namespace Kdig\MediaBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Kdig\OrientBundle\Entity\Bucket as Bucket;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface,
    Symfony\Component\HttpFoundation\Request,
    Symfony\Component\HttpFoundation\Response,
    Symfony\Component\HttpFoundation\JsonResponse,
    Sonata\AdminBundle\Admin\Admin as SontataAdmin,
    Sonata\MediaBundle\Admin\ORM\MediaAdmin,
    Sonata\MediaBundle\Provider\MediaProviderInterface,
    Symfony\Component\HttpFoundation\File\UploadedFile,
    Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
    
use Oneup\UploaderBundle\Event\PostPersistEvent;

use Kdig\MediaBundle\Entity\Media;

class UploadListener
{
    private $container;
    protected $em;
 
    public function __construct(ContainerInterface $container, \Doctrine\ORM\EntityManager $em)
    {
        $this->container = $container;
        $this->em = $em;
    }
    
    public function onUpload(PostPersistEvent $event)
    {
        $request = $event->getRequest();
        $response = $event->getResponse();
//        $file = $this->getFiles($request->files);
        $gallery = $request->get('gallery');
        $file = $event->getFile();
        // Optional: might be used to provide localized messages.
        $locale = $request->getLocale();
        $session = $request->getSession();
//        $pageId = $session->get('Page.last_edited');
//
//        $repository = $this->getDoctrine()->getRepository('NetworkingInitCmsBundle:Page');
//        $page = $repository->find($pageId);
//
//        if($page){
//            $locale = $page->getLocale();
//        }

        $url = '';
        $media = new Media();
        $media->setProviderName('sonata.media.provider.image');
        $media->setName($file->getFileName());
        $media->setBinaryContent($file);
        $media->setEnabled(true);
        //$media->setName('test');

        $this->em->persist($media);
        $this->em->flush();
        $path = $file->getPathName();

//        if ($file instanceof UploadedFile && $file->isValid()) {
//            try {
                /** @var $mediaManager \Sonata\MediaBundle\Admin\Manager\DoctrineORMManager */
//                $mediaManager = $request->get('sonata.media.manager.media');

                /** @var $mediaAdmin \Sonata\MediaBundle\Admin\ORM\MediaAdmin */
//                $mediaAdmin = $request->get('sonata.media.admin.media');

                /** @var $provider \Sonata\MediaBundle\Provider\MediaProviderInterface */
//                $provider = $request->get('sonata.media.provider.image');

//                $context = $mediaAdmin->getPool()->getDefaultContext();
//                $mediaClass = $mediaAdmin->getClass();

                /** @var $media \Sonata\MediaBundle\Model\MediaInterface */
//                $media = new $mediaClass();
//                $media->setProviderName($provider->getName());
//                $media->setContext($context);
//                $media->setEnabled(true);

//                $media->setLocale($locale);

//                $media->setName($file->getClientOriginalName());
//                $media->setBinaryContent($file);
//                $mediaManager->save($media);
//                $path = $provider->generatePublicUrl($media, 'reference');

                // Check the $_FILES array and save the file. Assign the correct path to a variable ($url).
//                $url = $path;
//                // Usually you will only assign something here if the file could not be uploaded.
//                $message = '';
//                $status = 200;
//            } catch (\Exception $e) {
//                $message = $e->getMessage();
//                $status = 500;
//            }
//        } elseif ($file instanceof UploadedFile && !$file->isValid()) {
//
//            $status = 500;
//        } else {

//            $message = $this->admin->trans(
//                'error.file_upload_size',
//                array('%max_server_size%' => ini_get('upload_max_filesize'))
//            );
//            $status = 500;
//        }

        
        $aclProvider = $this->container->get('problematic.acl_manager');
        $user = $this->container->get('security.context')->getToken()->getUser();
        if ($user) {
            $aclProvider->addObjectPermission($media, MaskBuilder::MASK_OWNER, $user);
        }
        $response['name'] = $media->getName();
        $response['id'] = $media->getId();
        $response['url'] = $path;
    }
}
