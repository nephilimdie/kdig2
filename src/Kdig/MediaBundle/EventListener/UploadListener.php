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
    
use Oneup\UploaderBundle\Event\PostPersistEvent;

use Kdig\MediaBundle\Entity\Media;

class UploadListener
{
    private $container;
 
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
    
    public function onUpload(PostPersistEvent $event)
    {
        $request = $event->getRequest();
        $file = $this->getFiles($request->files);
//        die('de dump is ' . var_dump($file));
        $gallery = $request->get('gallery');
        $file = $request->files->get('upload');

        // Optional: might be used to provide localized messages.
        $locale = $this->getRequest()->getLocale();
        $session = $this->getRequest()->getSession();
//        $pageId = $session->get('Page.last_edited');
//
//        $repository = $this->getDoctrine()->getRepository('NetworkingInitCmsBundle:Page');
//        $page = $repository->find($pageId);
//
//        if($page){
//            $locale = $page->getLocale();
//        }

        $url = '';

        if ($file instanceof UploadedFile && $file->isValid()) {
            try {
                /** @var $mediaManager \Sonata\MediaBundle\Admin\Manager\DoctrineORMManager */
                $mediaManager = $this->get('sonata.media.manager.media');

                /** @var $mediaAdmin \Sonata\MediaBundle\Admin\ORM\MediaAdmin */
                $mediaAdmin = $this->get('sonata.media.admin.media');

                /** @var $provider \Sonata\MediaBundle\Provider\MediaProviderInterface */
                $provider = $this->get($providerName);

                $context = $mediaAdmin->getPool()->getDefaultContext();
                $mediaClass = $mediaAdmin->getClass();

                /** @var $media \Sonata\MediaBundle\Model\MediaInterface */
                $media = new $mediaClass();
                $media->setProviderName($provider->getName());
                $media->setContext($context);
                $media->setEnabled(true);

//                $media->setLocale($locale);

                $media->setName($file->getClientOriginalName());
                $media->setBinaryContent($file);
                $mediaManager->save($media);
                $path = $provider->generatePublicUrl($media, 'reference');

                // Check the $_FILES array and save the file. Assign the correct path to a variable ($url).
                $url = $path;
                // Usually you will only assign something here if the file could not be uploaded.
                $message = '';
                $status = 200;
            } catch (\Exception $e) {
                $message = $e->getMessage();
                $status = 500;
            }
        } elseif ($file instanceof UploadedFile && !$file->isValid()) {

            $status = 500;
        } else {

            $message = $this->admin->trans(
                'error.file_upload_size',
                array('%max_server_size%' => ini_get('upload_max_filesize'))
            );
            $status = 500;
        }

        
        // da sistemare
        $response = "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, '$url', '$message');</script>";

        $aclProvider = $this->container->get('problematic.acl_manager');
        $user = $this->container->get('security.context')->getToken()->getUser();
        if ($user) {
            $aclProvider->addObjectPermission($media, MaskBuilder::MASK_OWNER, $user);
        }
        $response['name'] = 'value';
    }
}