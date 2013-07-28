<?php

namespace Kdig\OrientBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BucketType extends AbstractType
{
    protected $areaid;
    protected $usid;
    
    public function __construct($areaid, $usid = null)
    {
        $this->areaid = $areaid;
        $this->usid = $usid;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $idarea = $this->areaid;
        $usid = $this->usid;
        
        $builder
            ->add('us', 'entity', array(
                'class' => 'KdigArchaeologicalBundle:Us',
                'query_builder' => function($repository) use ($idarea, $usid) {
                    $expr = new \Doctrine\ORM\Query\Expr();
                    $idiota = $repository->createQueryBuilder('p')
                        ->setParameter('idarea', $idarea)
                        ->add('where', ($expr->in('p.area', ':idarea')))
//                            ->where('p.area = :idarea')
                        ->orderBy('p.name', 'ASC'); 
                    
                    if($usid) $idiota->setParameter('usid', $usid)->andWhere('p.id = :usid');
                    
                    return $idiota;
                },
                'required' => true,
                'label' => 'SU Definition',
                'help_block'  => 'It defines the SU number'
            ));
        $builder
            ->add('name', null, array(
                'label' => 'Bucket Definition',
                'help_block'  => 'It is automatically given by the DB - if does not appear press the reload button'
            ))
            ->add('remarks', 'textarea', array(
                'label' => 'Description',
                'help_block'  => 'some usefull help message',
                'required' => false
            ))
            ->add('media', 'entity', array(
                'class' => 'KdigMediaBundle:Media',
                'required' => false,
                'multiple' => true
            ))
            ->add('bucketsheet')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Kdig\OrientBundle\Entity\Bucket'
        ));
    }

    public function getName()
    {
        return 'kdig_orientbundle_buckettype';
    }
}
