<?php

namespace Kdig\OrientBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Kdig\ArchaeologicalBundle\Form\PrepotteryType;
use Kdig\OrientBundle\Form\Potteryvoc\VocPotterySurfacetratinType;
use Kdig\OrientBundle\Form\Potteryvoc\VocPotterySurfacetratoutType;
use Kdig\OrientBundle\Form\Potteryvoc\VocPotterySurfacetratinoutType;
use Kdig\OrientBundle\Form\Potteryvoc\VocPotteryDecorationinType;
use Kdig\OrientBundle\Form\Potteryvoc\VocPotteryDecorationoutType;
use Kdig\OrientBundle\Form\Potteryvoc\VocPotteryDecorationinoutType;
 
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
                'required' => true,
                'widget_type'  => ""
            ))
            ->add('outercolor', null, array(
                'label' => 'Outer color',
                'required' => false,
                'widget_type'  => ""
            ))
            ->add('innercolor', null, array(
                'label' => 'Inner color',
                'required' => false,
                'widget_type'  => ""
            ))
            ->add('fabriccolor', null, array(
                'label' => 'Fabric color',
                'required' => false,
                'widget_type'  => ""
            ))
            ->add('rimdiameter', null, array(
                'label' => 'Rim Diameter',
                'required' => false,
                'widget_type'  => ""
            ))
            ->add('rimwidth', null, array(
                'label' => 'Rim width',
                'required' => false,
                'widget_type'  => ""
            ))
            ->add('wallwidth', null, array(
                'label' => 'Wall width',
                'required' => false,
                'widget_type'  => ""
            ))
            ->add('maxwalldiameter', null, array(
                'label' => 'Max diameter',
                'required' => false,
                'widget_type'  => ""
            ))
            ->add('bottomwidth', null, array(
                'label' => 'Bottom width',
                'required' => false,
                'widget_type'  => ""
            ))
            ->add('height', null, array(
                'label' => 'Height',
                'required' => false,
                'widget_type'  => ""
            ))
            ->add('basediameter', null, array(
                'label' => 'Base diameter',
                'required' => false,
                'widget_type'  => ""
            ))
            ->add('restored', null, array(
                'label' => 'Restored',
                'required' => false,
                'widget_type'  => ""
            ))
            ->add('datation', null, array(
                'label' => 'Date',
                'required' => false,
                'widget_type'  => ""
            ))
            ->add('class', 'entity', array(
                'widget_control_group_attr' => array('class'=>'span4'),
                'widget_controls_attr' => array('class'=>'mycontrolsclass'),
                'label_attr' => array('class'=>'mylabelclass'),
                'class' => 'KdigOrientBundle:Potteryvoc\VocClass',
                'query_builder' => function($repository) {
                    $idiota = $repository->createQueryBuilder('p')->orderBy('p.number', 'ASC'); return $idiota;
                },
                
                'expanded' => true, 'label' => 'Class', 'required' => true, 'attr'=> array('class' => 'selection ')))
            ->add('shape', 'entity', array(
                'widget_control_group_attr' => array('class'=>'span4'),
                'widget_controls_attr' => array('class'=>'mycontrolsclass'),
                'label_attr' => array('class'=>'mylabelclass'),
                'class' => 'KdigOrientBundle:Potteryvoc\VocShape',
                'query_builder' => function($repository) {
                    $idiota = $repository->createQueryBuilder('p')->orderBy('p.number', 'ASC'); return $idiota;
                },
                
                'expanded' => true, 'label' => 'Shape', 'required' => true, 'attr'=> array('class' => 'selection ')))
            ->add('rim', 'entity', array(
                'widget_control_group_attr' => array('class'=>'span4'),
                'widget_controls_attr' => array('class'=>'mycontrolsclass'),
                'label_attr' => array('class'=>'mylabelclass'),
                'class' => 'KdigOrientBundle:Potteryvoc\VocRim',
                'query_builder' => function($repository) {
                    $idiota = $repository->createQueryBuilder('p')->orderBy('p.number', 'ASC'); return $idiota;
                },
                
                'expanded' => true, 'label' => 'Rim', 'required' => true, 'attr'=> array('class' => 'selection ')))
            ->add('neck', 'entity', array(
                'widget_control_group_attr' => array('class'=>'span4'),
                'widget_controls_attr' => array('class'=>'mycontrolsclass'),
                'label_attr' => array('class'=>'mylabelclass'),
                'class' => 'KdigOrientBundle:Potteryvoc\VocNeck',
                'query_builder' => function($repository) {
                    $idiota = $repository->createQueryBuilder('p')->orderBy('p.number', 'ASC'); return $idiota;
                },
                'expanded' => true, 'label' => 'Neck', 'required' => true, 'attr'=> array('class' => 'selection ')))
            ->add('wall', 'entity', array(
                'widget_control_group_attr' => array('class'=>'span4'),
                'widget_controls_attr' => array('class'=>'mycontrolsclass'),
                'label_attr' => array('class'=>'mylabelclass'),
                'class' => 'KdigOrientBundle:Potteryvoc\VocWall',
                'query_builder' => function($repository) {
                    $idiota = $repository->createQueryBuilder('p')->orderBy('p.number', 'ASC'); return $idiota;
                },
                
                'expanded' => true, 'label' => 'Wall', 'required' => true, 'attr'=> array('class' => 'selection ')))
            ->add('upperwall', 'entity', array(
                'class' => 'KdigOrientBundle:Potteryvoc\VocUpperWall',
                'query_builder' => function($repository) {
                    $idiota = $repository->createQueryBuilder('p')->orderBy('p.number', 'ASC'); return $idiota;
                },
                
                'expanded' => true, 'label' => 'Upper wall', 'required' => true, 'attr'=> array('class' => 'selection ')))
            ->add('lowerwall', 'entity', array(
                'class' => 'KdigOrientBundle:Potteryvoc\VocLowerWall',
                'query_builder' => function($repository) {
                    $idiota = $repository->createQueryBuilder('p')->orderBy('p.number', 'ASC'); return $idiota;
                },
                
                'expanded' => true, 'label' => 'Lower wall', 'required' => true, 'attr'=> array('class' => 'selection ')))
            ->add('base', 'entity', array(
                'class' => 'KdigOrientBundle:Potteryvoc\VocBase',
                'query_builder' => function($repository) {
                    $idiota = $repository->createQueryBuilder('p')->orderBy('p.number', 'ASC'); return $idiota;
                },
                
                'expanded' => true, 'label' => 'Base', 'required' => true, 'attr'=> array('class' => 'selection ')))
            ->add('handle', 'entity', array(
                'class' => 'KdigOrientBundle:Potteryvoc\VocHandle',
                'query_builder' => function($repository) {
                    $idiota = $repository->createQueryBuilder('p')->orderBy('p.number', 'ASC'); return $idiota;
                },
                
                'expanded' => true, 'label' => 'Handle', 'required' => true, 'attr'=> array('class' => 'selection ')))
            ->add('handleposition', 'entity', array(
                'class' => 'KdigOrientBundle:Potteryvoc\VocHandlePosition',
                'query_builder' => function($repository) {
                    $idiota = $repository->createQueryBuilder('p')->orderBy('p.number', 'ASC'); return $idiota;
                },
                
                'expanded' => true, 'label' => 'Handle position', 'required' => true, 'attr'=> array('class' => 'selection ')))
            ->add('spout', 'entity', array(
                'class' => 'KdigOrientBundle:Potteryvoc\VocSpout',
                'query_builder' => function($repository) {
                    $idiota = $repository->createQueryBuilder('p')->orderBy('p.number', 'ASC'); return $idiota;
                },
                
                'expanded' => true, 'label' => 'Spout', 'required' => true, 'attr'=> array('class' => 'selection ')))
            ->add('spoutposition', 'entity', array(
                'class' => 'KdigOrientBundle:Potteryvoc\VocSpoutPosition',
                'query_builder' => function($repository) {
                    $idiota = $repository->createQueryBuilder('p')->orderBy('p.number', 'ASC'); return $idiota;
                },
                
                'expanded' => true, 'label' => 'Spout position', 'required' => true, 'attr'=> array('class' => 'selection ')))
            ->add('preservation', 'entity', array(
                'class' => 'KdigOrientBundle:Potteryvoc\VocPreservation',
                'query_builder' => function($repository) {
                    $idiota = $repository->createQueryBuilder('p')->orderBy('p.number', 'ASC'); return $idiota;
                },
                
                'expanded' => true, 'label' => 'Preservation', 'required' => true, 'attr'=> array('class' => 'selection ')))
            ->add('technique', 'entity', array(
                'class' => 'KdigOrientBundle:Potteryvoc\VocTechnique',
                'query_builder' => function($repository) {
                    $idiota = $repository->createQueryBuilder('p')->orderBy('p.number', 'ASC'); return $idiota;
                },
                
                'expanded' => true, 'label' => 'Technique', 'required' => true, 'attr'=> array('class' => 'selection ')))
            ->add('firing', 'entity', array(
                'class' => 'KdigOrientBundle:Potteryvoc\VocFiring',
                'query_builder' => function($repository) {
                    $idiota = $repository->createQueryBuilder('p')->orderBy('p.number', 'ASC'); return $idiota;
                },
                'expanded' => true, 'label' => 'Firing', 'required' => true, 'attr'=> array('class' => 'selection ')))
            ->add('inclusion', 'entity', array(
                'class' => 'KdigOrientBundle:Potteryvoc\VocInclusion',
                'query_builder' => function($repository) {
                    $idiota = $repository->createQueryBuilder('p')->orderBy('p.number', 'ASC'); return $idiota;
                },
                
                'expanded' => true, 'label' => 'Inclusion', 'required' => true, 'attr'=> array('class' => 'selection ')))
            ->add('inclusionsize', 'entity', array(
                'class' => 'KdigOrientBundle:Potteryvoc\VocInclusionSize',
                'query_builder' => function($repository) {
                    $idiota = $repository->createQueryBuilder('p')->orderBy('p.number', 'ASC'); return $idiota;
                },
                
                'expanded' => true, 'label' => 'Inclusion size', 'required' => true, 'attr'=> array('class' => 'selection ')))
            ->add('inclusionfrequency', 'entity', array(
                'class' => 'KdigOrientBundle:Potteryvoc\VocInclusionFrequency',
                'query_builder' => function($repository) {
                    $idiota = $repository->createQueryBuilder('p')->orderBy('p.number', 'ASC'); return $idiota;
                },
                
                'expanded' => true, 'label' => 'Inclusion frequency', 'required' => true, 'attr'=> array('class' => 'selection ')))
            ->add('surfacetratin', 'collection', array(
                'type' => new VocPotterySurfacetratinType(), 
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'widget_add_btn' => array('label' => 'Add Inner Surface Treatment', 'attr' => array('class' => 'btn btn-primary')),
                'options' => array( // options for collection fields
                    'widget_remove_btn' => array('label' => 'remove', 'attr' => array('class' => 'btn btn-primary')),
                    'attr' => array('class' => 'span3'),
//                    'widget_addon' => array(
//                        'type' => 'prepend',
//                        'text' => '@',
//                    ),
                    'widget_control_group' => false,
                ),
                'label' => 'Inner surface treatment',
                'required' => false,
                
                'show_child_legend' => true
            ))
            ->add('surfacetratout', 'collection', array(
                'type' => new VocPotterySurfacetratoutType(), 
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'widget_add_btn' => array('label' => 'Add Outer surface treatment', 'attr' => array('class' => 'btn btn-primary')),
                'options' => array( // options for collection fields
                    'widget_remove_btn' => array('label' => 'remove', 'attr' => array('class' => 'btn btn-primary')),
                    'attr' => array('class' => 'span3'),
//                    'widget_addon' => array(
//                        'type' => 'prepend',
//                        'text' => '@',
//                    ),
                    'widget_control_group' => false,
                ),
                'label' => 'Outer surface treatment',
                'required' => false,
                
                'show_child_legend' => true
            ))
            ->add('surfacetratinout', 'collection', array(
                'type' => new VocPotterySurfacetratinoutType(), 
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'widget_add_btn' => array('label' => 'Add Inner & Outer surface treatment', 'attr' => array('class' => 'btn btn-primary')),
                'options' => array( // options for collection fields
                    'widget_remove_btn' => array('label' => 'remove', 'attr' => array('class' => 'btn btn-primary')),
                    'attr' => array('class' => 'span3'),
//                    'widget_addon' => array(
//                        'type' => 'prepend',
//                        'text' => '@',
//                    ),
                    'widget_control_group' => false,
                ),
                'label' => 'Inner & Outer surface treatment',
                'required' => false,
                
                'show_child_legend' => true
            ))
            ->add('potdecorationin', 'collection', array(
                'type' => new VocPotteryDecorationinType(), 
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'widget_add_btn' => array('label' => 'Add Inner decoration', 'attr' => array('class' => 'btn btn-primary')),
                'options' => array( // options for collection fields
                    'widget_remove_btn' => array('label' => 'remove', 'attr' => array('class' => 'btn btn-primary')),
                    'attr' => array('class' => 'span3'),
//                    'widget_addon' => array(
//                        'type' => 'prepend',
//                        'text' => '@',
//                    ),
                    'widget_control_group' => false,
                ),
                'label' => 'Inner decoration',
                'required' => false,
                
                'show_child_legend' => true
            ))
            ->add('potdecorationout', 'collection', array(
                'type' => new VocPotteryDecorationoutType(), 
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'widget_add_btn' => array('label' => 'Add Outer decoration', 'attr' => array('class' => 'btn btn-primary')),
                'options' => array( // options for collection fields
                    'widget_remove_btn' => array('label' => 'remove', 'attr' => array('class' => 'btn btn-primary')),
                    'attr' => array('class' => 'span3'),
//                    'widget_addon' => array(
//                        'type' => 'prepend',
//                        'text' => '@',
//                    ),
                    'widget_control_group' => false,
                ),
                'label' => 'Outer decoration',
                'required' => false,
                
                'show_child_legend' => true
            ))
            ->add('potdecorationinout', 'collection', array(
                'type' => new VocPotteryDecorationinoutType(), 
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'widget_add_btn' => array('label' => 'Add Inner & Outer decoration', 'attr' => array('class' => 'btn btn-primary')),
                'options' => array( // options for collection fields
                    'widget_remove_btn' => array('label' => 'remove', 'attr' => array('class' => 'btn btn-primary')),
                    'attr' => array('class' => 'span3'),
//                    'widget_addon' => array(
//                        'type' => 'prepend',
//                        'text' => '@',
//                    ),
                    'widget_control_group' => false,
                ),
                'label' => 'Inner & Outer decoration',
                'required' => false,
                
                'show_child_legend' => true
            ))
            ->add('remarks', 'textarea', array(
                'label' => 'Description',
                'help_inline'  => 'Scrivi qualcosa.. -.-',
                'required' => false,
                'widget_type'  => ""
            ))
//            ->add('media', 'entity', array(
//                'class' => 'KdigMediaBundle:Media',
//                'required' => false,
//                'multiple' => true
//            ))
        ;
                
        $builder->setAttribute('class', 'span4');
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
