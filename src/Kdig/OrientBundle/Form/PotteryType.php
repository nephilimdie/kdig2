<?php

namespace Kdig\OrientBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PotteryType extends AbstractType
{
    protected $bucketid;
    
    public function __construct($bucketid = null)
    {
        $this->bucketid = $bucketid;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $bucketid = $this->bucketid;
        
        $builder
            ->add('prepottery', new PrepotteryType($bucketid) )
            ->add('tcode', null, array(
                'label' => 'tcode',
                'required' => false
            ))
            ->add('typecontext', null, array(
                'label' => 'Type of context',
                'required' => true
            ))
            ->add('outercolor', null, array(
                'label' => 'Outer color',
                'required' => false
            ))
            ->add('innercolor', null, array(
                'label' => 'Inner color',
                'required' => false
            ))
            ->add('fabriccolor', null, array(
                'label' => 'Fabric color',
                'required' => false
            ))
            ->add('rimdiameter', null, array(
                'label' => 'Rim Diameter',
                'required' => false
            ))
            ->add('rimwidth', null, array(
                'label' => 'Rim width',
                'required' => false
            ))
            ->add('wallwidth', null, array(
                'label' => 'Wall width',
                'required' => false
            ))
            ->add('maxwalldiameter', null, array(
                'label' => 'Max diameter',
                'required' => false
            ))
            ->add('bottomwidth', null, array(
                'label' => 'Bottom width',
                'required' => false
            ))
            ->add('height', null, array(
                'label' => 'Height',
                'required' => false
            ))
            ->add('basediameter', null, array(
                'label' => 'Base diameter',
                'required' => false
            ))
            ->add('restored', null, array(
                'label' => 'Restored',
                'required' => false
            ))
            ->add('datation', null, array(
                'label' => 'Date',
                'required' => false
            ))
            /*->add('media', 'entity', array(
                'class' => 'KdigArchaelogicalBundle:Media',
                'required' => false,
                'multiple' => true
            ))*/
            ->add('class', 'entity', array(
                'class' => 'KdigArchaelogicalBundle:VocClass',
                'query_builder' => function($repository) {
                    $idiota = $repository->createQueryBuilder('p')->orderBy('p.number', 'ASC'); return $idiota;
                },
                'expanded' => true, 'label' => 'Class', 'required' => true, 'attr'=> array('class' => 'selection ')))
            ->add('shape', 'entity', array(
                'class' => 'KdigArchaelogicalBundle:VocShape',
                'query_builder' => function($repository) {
                    $idiota = $repository->createQueryBuilder('p')->orderBy('p.number', 'ASC'); return $idiota;
                },
                'expanded' => true, 'label' => 'Shape', 'required' => true, 'attr'=> array('class' => 'selection ')))
            ->add('rim', 'entity', array(
                'class' => 'KdigArchaelogicalBundle:VocRim',
                'query_builder' => function($repository) {
                    $idiota = $repository->createQueryBuilder('p')->orderBy('p.number', 'ASC'); return $idiota;
                },
                'expanded' => true, 'label' => 'Rim', 'required' => true, 'attr'=> array('class' => 'selection ')))
            ->add('neck', 'entity', array(
                'class' => 'KdigArchaelogicalBundle:VocNeck',
                'query_builder' => function($repository) {
                    $idiota = $repository->createQueryBuilder('p')->orderBy('p.number', 'ASC'); return $idiota;
                },
                'expanded' => true, 'label' => 'Neck', 'required' => true, 'attr'=> array('class' => 'selection ')))
            ->add('wall', 'entity', array(
                'class' => 'KdigArchaelogicalBundle:VocWall',
                'query_builder' => function($repository) {
                    $idiota = $repository->createQueryBuilder('p')->orderBy('p.number', 'ASC'); return $idiota;
                },
                'expanded' => true, 'label' => 'Wall', 'required' => true, 'attr'=> array('class' => 'selection ')))
            ->add('upperwall', 'entity', array(
                'class' => 'KdigArchaelogicalBundle:VocUpperWall',
                'query_builder' => function($repository) {
                    $idiota = $repository->createQueryBuilder('p')->orderBy('p.number', 'ASC'); return $idiota;
                },
                'expanded' => true, 'label' => 'Upper wall', 'required' => true, 'attr'=> array('class' => 'selection ')))
            ->add('lowerwall', 'entity', array(
                'class' => 'KdigArchaelogicalBundle:VocLowerWall',
                'query_builder' => function($repository) {
                    $idiota = $repository->createQueryBuilder('p')->orderBy('p.number', 'ASC'); return $idiota;
                },
                'expanded' => true, 'label' => 'Lower wall', 'required' => true, 'attr'=> array('class' => 'selection ')))
            ->add('base', 'entity', array(
                'class' => 'KdigArchaelogicalBundle:VocBase',
                'query_builder' => function($repository) {
                    $idiota = $repository->createQueryBuilder('p')->orderBy('p.number', 'ASC'); return $idiota;
                },
                'expanded' => true, 'label' => 'Base', 'required' => true, 'attr'=> array('class' => 'selection ')))
            ->add('handle', 'entity', array(
                'class' => 'KdigArchaelogicalBundle:VocHandle',
                'query_builder' => function($repository) {
                    $idiota = $repository->createQueryBuilder('p')->orderBy('p.number', 'ASC'); return $idiota;
                },
                'expanded' => true, 'label' => 'Handle', 'required' => true, 'attr'=> array('class' => 'selection ')))
            ->add('handleposition', 'entity', array(
                'class' => 'KdigArchaelogicalBundle:VocHandlePosition',
                'query_builder' => function($repository) {
                    $idiota = $repository->createQueryBuilder('p')->orderBy('p.number', 'ASC'); return $idiota;
                },
                'expanded' => true, 'label' => 'Handle position', 'required' => true, 'attr'=> array('class' => 'selection ')))
            ->add('spout', 'entity', array(
                'class' => 'KdigArchaelogicalBundle:VocSpout',
                'query_builder' => function($repository) {
                    $idiota = $repository->createQueryBuilder('p')->orderBy('p.number', 'ASC'); return $idiota;
                },
                'expanded' => true, 'label' => 'Spout', 'required' => true, 'attr'=> array('class' => 'selection ')))
            ->add('spoutposition', 'entity', array(
                'class' => 'KdigArchaelogicalBundle:VocSpoutPosition',
                'query_builder' => function($repository) {
                    $idiota = $repository->createQueryBuilder('p')->orderBy('p.number', 'ASC'); return $idiota;
                },
                'expanded' => true, 'label' => 'Spout position', 'required' => true, 'attr'=> array('class' => 'selection ')))
            ->add('preservation', 'entity', array(
                'class' => 'KdigArchaelogicalBundle:VocPreservation',
                'query_builder' => function($repository) {
                    $idiota = $repository->createQueryBuilder('p')->orderBy('p.number', 'ASC'); return $idiota;
                },
                'expanded' => true, 'label' => 'Preservation', 'required' => true, 'attr'=> array('class' => 'selection ')))
            ->add('technique', 'entity', array(
                'class' => 'KdigArchaelogicalBundle:VocTechnique',
                'query_builder' => function($repository) {
                    $idiota = $repository->createQueryBuilder('p')->orderBy('p.number', 'ASC'); return $idiota;
                },
                'expanded' => true, 'label' => 'Technique', 'required' => true, 'attr'=> array('class' => 'selection ')))
            ->add('firing', 'entity', array(
                'class' => 'KdigArchaelogicalBundle:VocFiring',
                'query_builder' => function($repository) {
                    $idiota = $repository->createQueryBuilder('p')->orderBy('p.number', 'ASC'); return $idiota;
                },
                'expanded' => true, 'label' => 'Firing', 'required' => true, 'attr'=> array('class' => 'selection ')))
            ->add('inclusion', 'entity', array(
                'class' => 'KdigArchaelogicalBundle:VocInclusion',
                'query_builder' => function($repository) {
                    $idiota = $repository->createQueryBuilder('p')->orderBy('p.number', 'ASC'); return $idiota;
                },
                'expanded' => true, 'label' => 'Inclusion', 'required' => true, 'attr'=> array('class' => 'selection ')))
            ->add('inclusionsize', 'entity', array(
                'class' => 'KdigArchaelogicalBundle:VocInclusionSize',
                'query_builder' => function($repository) {
                    $idiota = $repository->createQueryBuilder('p')->orderBy('p.number', 'ASC'); return $idiota;
                },
                'expanded' => true, 'label' => 'Inclusion size', 'required' => true, 'attr'=> array('class' => 'selection ')))
            ->add('inclusionfrequency', 'entity', array(
                'class' => 'KdigArchaelogicalBundle:VocInclusionFrequency',
                'query_builder' => function($repository) {
                    $idiota = $repository->createQueryBuilder('p')->orderBy('p.number', 'ASC'); return $idiota;
                },
                'expanded' => true, 'label' => 'Inclusion frequency', 'required' => true, 'attr'=> array('class' => 'selection ')))
            ->add('surfacetratin', 'collection', array(
                'type' => new VocPotterySurfacetratinType(), 
                'allow_add'    => true,
                'allow_delete' => true,
                'prototype'    => true,
                'by_reference' => false,
                'label' => 'Inner surface treatment',
                'required' => false
            ))
            ->add('surfacetratout', 'collection', array(
                'type' => new VocPotterySurfacetratoutType(), 
                'allow_add'    => true,
                'allow_delete' => true,
                'prototype'    => true,
                'by_reference' => false,
                'label' => 'Outer surface treatment',
                'required' => false
            ))
            ->add('surfacetratinout', 'collection', array(
                'type' => new VocPotterySurfacetratinoutType(), 
                'allow_add'    => true,
                'allow_delete' => true,
                'prototype'    => true,
                'by_reference' => false,
                'label' => 'Inner & Outer surface treatment',
                'required' => false
            ))
            ->add('potdecorationin', 'collection', array(
                'type' => new VocPotteryDecorationinType(), 
                'allow_add'    => true,
                'allow_delete' => true,
                'prototype'    => true,
                'by_reference' => false,
                'label' => 'Inner decoration',
                'required' => false
            ))
            ->add('potdecorationout', 'collection', array(
                'type' => new VocPotteryDecorationoutType(), 
                'allow_add'    => true,
                'allow_delete' => true,
                'prototype'    => true,
                'by_reference' => false,
                'label' => 'Outer decoration',
                'required' => false
            ))
            ->add('potdecorationinout', 'collection', array(
                'type' => new VocPotteryDecorationinoutType(), 
                'allow_add'    => true,
                'allow_delete' => true,
                'prototype'    => true,
                'by_reference' => false,
                'label' => 'Inner & Outer decoration',
                'required' => false
            ))
            ->add('remarks', 'textarea', array(
                'label' => 'Description',
                'help'  => 'Scrivi qualcosa.. -.-',
                'required' => false
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Kdig\OrientBundle\Entity\Pottery'
        ));
    }

    public function getName()
    {
        return 'kdig_orientbundle_potterytype';
    }
}
