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
    protected $us;
    
    public function __construct($bucketid, $usid = null)
    {
        $this->bucketid = $bucketid;
        $this->us = $usid;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $bucketid = $this->bucketid;
        $usid = $this->us;
        
        
        $builder
            ->add('prepottery', new PrepotteryType($bucketid, $usid) )
            ->add('typecontext', null, array(
                'label_attr' => array('class'=>'mylabelclass control-label'),
                'label' => 'Type of context',
                'required' => false,
                'widget_type'  => "block"
            ))
            ->add('class', 'entity', array(
                'label_attr' => array('class'=>'mylabelclass control-label'),
                'class' => 'KdigOrientBundle:Potteryvoc\VocClass',
                'query_builder' => function($repository) {
                    $idiota = $repository->createQueryBuilder('p')->orderBy('p.number', 'ASC'); return $idiota;
                },
                'expanded' => true, 'label' => 'Class', 'required' => true, 
                'attr'=> array('class' => 'selection control-group ')
            ))
            ->add('shape', 'entity', array(
                'attr' => array('class'=>'labelchoice'),
                'label_attr' => array('class'=>'mylabelclass control-label'),
                'class' => 'KdigOrientBundle:Potteryvoc\VocShape',
                'query_builder' => function($repository) {
                    $idiota = $repository->createQueryBuilder('p')->orderBy('p.number', 'ASC'); return $idiota;
                },
                'expanded' => true, 'label' => 'Shape', 'required' => true, 'attr'=> array('class' => 'selection control-group ')))
            ->add('rim', 'entity', array(
                'attr' => array('class'=>'labelchoice'),
                'label_attr' => array('class'=>'mylabelclass control-label'),
                'class' => 'KdigOrientBundle:Potteryvoc\VocRim',
                'query_builder' => function($repository) {
                    $idiota = $repository->createQueryBuilder('p')->orderBy('p.number', 'ASC'); return $idiota;
                },
                'expanded' => true, 'label' => 'Rim', 'required' => true, 'attr'=> array('class' => 'selection control-group ')))
            ->add('neck', 'entity', array(
                'attr' => array('class'=>'labelchoice'),
                'label_attr' => array('class'=>'mylabelclass control-label'),
                'class' => 'KdigOrientBundle:Potteryvoc\VocNeck',
                'query_builder' => function($repository) {
                    $idiota = $repository->createQueryBuilder('p')->orderBy('p.number', 'ASC'); return $idiota;
                },
                'expanded' => true, 'label' => 'Neck', 'required' => true, 'attr'=> array('class' => 'selection control-group ')))
            ->add('wall', 'entity', array(
                'attr' => array('class'=>'labelchoice'),
                'label_attr' => array('class'=>'mylabelclass control-label'),
                'class' => 'KdigOrientBundle:Potteryvoc\VocWall',
                'query_builder' => function($repository) {
                    $idiota = $repository->createQueryBuilder('p')->orderBy('p.number', 'ASC'); return $idiota;
                },
                'expanded' => true, 'label' => 'Wall', 'required' => true, 'attr'=> array('class' => 'selection control-group ')))
            ->add('upperwall', 'entity', array(
                'attr' => array('class'=>'labelchoice'),
                'label_attr' => array('class'=>'mylabelclass control-label'),
                'class' => 'KdigOrientBundle:Potteryvoc\VocUpperWall',
                'query_builder' => function($repository) {
                    $idiota = $repository->createQueryBuilder('p')->orderBy('p.number', 'ASC'); return $idiota;
                },
                'expanded' => true, 'label' => 'Upper wall', 'required' => true, 'attr'=> array('class' => 'selection control-group ')))
            ->add('lowerwall', 'entity', array(
                'attr' => array('class'=>'labelchoice'),
                'label_attr' => array('class'=>'mylabelclass control-label'),
                'class' => 'KdigOrientBundle:Potteryvoc\VocLowerWall',
                'query_builder' => function($repository) {
                    $idiota = $repository->createQueryBuilder('p')->orderBy('p.number', 'ASC'); return $idiota;
                },
                'expanded' => true, 'label' => 'Lower wall', 'required' => true, 'attr'=> array('class' => 'selection control-group ')))
            ->add('base', 'entity', array(
                'attr' => array('class'=>'labelchoice'),
                'label_attr' => array('class'=>'mylabelclass control-label'),
                'class' => 'KdigOrientBundle:Potteryvoc\VocBase',
                'query_builder' => function($repository) {
                    $idiota = $repository->createQueryBuilder('p')->orderBy('p.number', 'ASC'); return $idiota;
                },
                'expanded' => true, 'label' => 'Base', 'required' => true, 'attr'=> array('class' => 'selection control-group ')))
            ->add('handle', 'entity', array(
                'attr' => array('class'=>'labelchoice'),
                'label_attr' => array('class'=>'mylabelclass control-label'),
                'class' => 'KdigOrientBundle:Potteryvoc\VocHandle',
                'query_builder' => function($repository) {
                    $idiota = $repository->createQueryBuilder('p')->orderBy('p.number', 'ASC'); return $idiota;
                },
                'expanded' => true, 'label' => 'Handle', 'required' => true, 'attr'=> array('class' => 'selection control-group ')))
            ->add('handleposition', 'entity', array(
                
                'attr' => array('class'=>'labelchoice'),
                'label_attr' => array('class'=>'mylabelclass control-label'),
                'class' => 'KdigOrientBundle:Potteryvoc\VocHandlePosition',
                'query_builder' => function($repository) {
                    $idiota = $repository->createQueryBuilder('p')->orderBy('p.number', 'ASC'); return $idiota;
                },
                'expanded' => true, 'label' => 'Handle position', 'required' => true, 'attr'=> array('class' => 'selection control-group ')))
            ->add('spout', 'entity', array(
                
                'attr' => array('class'=>'labelchoice'),
                'label_attr' => array('class'=>'mylabelclass control-label'),
                'class' => 'KdigOrientBundle:Potteryvoc\VocSpout',
                'query_builder' => function($repository) {
                    $idiota = $repository->createQueryBuilder('p')->orderBy('p.number', 'ASC'); return $idiota;
                },
                'expanded' => true, 'label' => 'Spout', 'required' => true, 'attr'=> array('class' => 'selection control-group ')))
            ->add('spoutposition', 'entity', array(
                
                'attr' => array('class'=>'labelchoice'),
                'label_attr' => array('class'=>'mylabelclass control-label'),
                'class' => 'KdigOrientBundle:Potteryvoc\VocSpoutPosition',
                'query_builder' => function($repository) {
                    $idiota = $repository->createQueryBuilder('p')->orderBy('p.number', 'ASC'); return $idiota;
                }, 
                'expanded' => true, 'label' => 'Spout position', 'required' => true, 'attr'=> array('class' => 'selection control-group ')))
            ->add('preservation', 'entity', array(
                
                'attr' => array('class'=>'labelchoice'),
                'label_attr' => array('class'=>'mylabelclass control-label'),
                'class' => 'KdigOrientBundle:Potteryvoc\VocPreservation',
                'query_builder' => function($repository) {
                    $idiota = $repository->createQueryBuilder('p')->orderBy('p.number', 'ASC'); return $idiota;
                },
                'expanded' => true, 'label' => 'Preservation', 'required' => true, 'attr'=> array('class' => 'selection control-group ')))
            ->add('technique', 'entity', array(
                
                'attr' => array('class'=>'labelchoice'),
                'label_attr' => array('class'=>'mylabelclass control-label'),
                'class' => 'KdigOrientBundle:Potteryvoc\VocTechnique',
                'query_builder' => function($repository) {
                    $idiota = $repository->createQueryBuilder('p')->orderBy('p.number', 'ASC'); return $idiota;
                },
                'expanded' => true, 'label' => 'Technique', 'required' => true, 'attr'=> array('class' => 'selection control-group ')))
            ->add('inclusion', 'entity', array(
                'attr' => array('class'=>'labelchoice'),
                'label_attr' => array('class'=>'mylabelclass control-label'),
                'class' => 'KdigOrientBundle:Potteryvoc\VocInclusion',
                'query_builder' => function($repository) {
                    $idiota = $repository->createQueryBuilder('p')->orderBy('p.number', 'ASC'); return $idiota;
                },
                'expanded' => true, 'label' => 'Inclusion', 'required' => true, 'attr'=> array('class' => 'selection control-group ')))
            ->add('inclusionsize', 'entity', array(
                'attr' => array('class'=>'labelchoice'),
                'label_attr' => array('class'=>'mylabelclass control-label'),
                'class' => 'KdigOrientBundle:Potteryvoc\VocInclusionSize',
                'query_builder' => function($repository) {
                    $idiota = $repository->createQueryBuilder('p')->orderBy('p.number', 'ASC'); return $idiota;
                },
                'expanded' => true, 'label' => 'Inclusion size', 'required' => true, 'attr'=> array('class' => 'selection control-group ')))
            ->add('inclusionfrequency', 'entity', array(
                'attr' => array('class'=>'labelchoice'),
                'label_attr' => array('class'=>'mylabelclass control-label'),
                'class' => 'KdigOrientBundle:Potteryvoc\VocInclusionFrequency',
                'query_builder' => function($repository) {
                    $idiota = $repository->createQueryBuilder('p')->orderBy('p.number', 'ASC'); return $idiota;
                },
                'expanded' => true, 'label' => 'Inclusion frequency', 'required' => true, 'attr'=> array('class' => 'selection control-group ')))
            ->add('surfacetratin', 'collection', array(
                'horizontal_input_wrapper_class' => 'col-sm-11',
                'attr' => array('class'=>'labelchoice'),
                'label_attr' => array('class'=>'mylabelclass control-label'),
                'type' => new VocPotterySurfacetratinType(), 
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'widget_add_btn' => array('label' => 'Add Inner Surface Treatment', 'attr' => array('class' => 'btn btn-primary')),
                'options' => array(
                    'horizontal_input_wrapper_class' => "col-lg-3",
                    'label_render' => false,
                    'widget_remove_btn' => array('label' => "remove this", "icon" => "pencil", 'attr' => array('class' => 'btn btn-danger')),
                ),
                'label' => 'Inner surface treatment',
                'required' => false,
                
                'show_child_legend' => true
            ))
            ->add('surfacetratout', 'collection', array(
                'horizontal_input_wrapper_class' => 'col-sm-11',
                'attr' => array('class'=>'labelchoice'),
                'label_attr' => array('class'=>'mylabelclass control-label'),
                'type' => new VocPotterySurfacetratoutType(), 
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'widget_add_btn' => array('label' => 'Add Outer surface treatment', 'attr' => array('class' => 'btn btn-primary')),
                'options' => array( 
                    'horizontal_input_wrapper_class' => "col-lg-3",
                    'label_render' => false,
                    'widget_remove_btn' => array('label' => "remove this", "icon" => "pencil", 'attr' => array('class' => 'btn btn-danger')),
                ),
                'label' => 'Outer surface treatment',
                'required' => false,
                
                'show_child_legend' => true
            ))
            ->add('surfacetratinout', 'collection', array(
                'horizontal_input_wrapper_class' => 'col-sm-11',
                'attr' => array('class'=>'labelchoice'),
                'label_attr' => array('class'=>'mylabelclass control-label'),
                'type' => new VocPotterySurfacetratinoutType(), 
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'widget_add_btn' => array('label' => 'Add Inner & Outer surface treatment', 'attr' => array('class' => 'btn btn-primary')),
                'options' => array(
                    'horizontal_input_wrapper_class' => "col-lg-3",
                    'label_render' => false,
                    'widget_remove_btn' => array('label' => "remove this", "icon" => "pencil", 'attr' => array('class' => 'btn btn-danger')),
                ),
                'label' => 'Inner & Outer surface treatment',
                'required' => false,
                
                'show_child_legend' => true
            ))
            ->add('potdecorationin', 'collection', array(
                'horizontal_input_wrapper_class' => 'col-sm-11',
                'attr' => array('class'=>'labelchoice'),
                'label_attr' => array('class'=>'mylabelclass control-label'),
                'type' => new VocPotteryDecorationinType(), 
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'widget_add_btn' => array('label' => 'Add Inner decoration', 'attr' => array('class' => 'btn btn-primary')),
                'options' => array( 
                    'horizontal_input_wrapper_class' => "col-lg-3",
                    'label_render' => false,
                    'widget_remove_btn' => array('label' => "remove this", "icon" => "pencil", 'attr' => array('class' => 'btn btn-danger')),
                ),
                'label' => 'Inner decoration',
                'required' => false,
                'show_child_legend' => true
            ))
            ->add('potdecorationout', 'collection', array(
                'horizontal_input_wrapper_class' => 'col-sm-11',
                'attr' => array('class'=>'labelchoice'),
                'label_attr' => array('class'=>'mylabelclass control-label'),
                'type' => new VocPotteryDecorationoutType(), 
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'widget_add_btn' => array('label' => 'Add Outer decoration', 'attr' => array('class' => 'btn btn-primary')),
                'options' => array(
                    'horizontal_input_wrapper_class' => "col-lg-3",
                    'label_render' => false,
                    'widget_remove_btn' => array('label' => "remove this", "icon" => "pencil", 'attr' => array('class' => 'btn btn-danger')),
                ),
                'label' => 'Outer decoration',
                'required' => false,
                'show_child_legend' => true
            ))
            ->add('potdecorationinout', 'collection', array(
                'horizontal_input_wrapper_class' => 'col-sm-11',
                'attr' => array('class'=>'labelchoice'),
                'label_attr' => array('class'=>'mylabelclass control-label'),
                'type' => new VocPotteryDecorationinoutType(), 
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'widget_add_btn' => array('label' => 'Add Inner & Outer decoration', 'attr' => array('class' => 'btn btn-primary')),
                'options' => array( 
                    'horizontal_input_wrapper_class' => "col-lg-3",
                    'label_render' => false,
                    'widget_remove_btn' => array('label' => "remove this", "icon" => "pencil", 'attr' => array('class' => 'btn btn-danger')),
                ),
                'label' => 'Inner & Outer decoration',
                'required' => false,
                
                'show_child_legend' => true
            ))
            ->add('remarks', 'textarea', array(
                'horizontal_input_wrapper_class' => 'col-sm-11',
                'attr' => array('class'=>'labelchoice', "rows" => 10, "cols" => 50),
                'label_attr' => array('class'=>'mylabelclass control-label'),
                'label' => 'Description',
                'help_block'  => 'Scrivi qualcosa.. -.-',
                'required' => false,
                'widget_type'  => ""
            ))
//            ->add('media', 'entity', array(
//                'class' => 'KdigMediaBundle:Media',
//                'required' => false,
//                'multiple' => true
//            ))
            ->add('firing', 'entity', array(
                'attr' => array('class'=>'labelchoice'),
                'label_attr' => array('class'=>'mylabelclass control-label'),
                'class' => 'KdigOrientBundle:Potteryvoc\VocFiring',
                'query_builder' => function($repository) {
                    $idiota = $repository->createQueryBuilder('p')->orderBy('p.number', 'ASC'); return $idiota;
                },
                'expanded' => true, 'label' => 'Firing', 'required' => true, 'attr'=> array('class' => 'selection control-group ')))
            ->add('outercolor', null, array(
                'attr' => array('class'=>'labelchoice'),
                'label_attr' => array('class'=>'mylabelclass control-label'),
                'label' => 'Outer color',
                'required' => false,
                'widget_type'  => ""
            ))
            ->add('innercolor', null, array(
                'attr' => array('class'=>'labelchoice'),
                'label_attr' => array('class'=>'mylabelclass control-label'),
                'label' => 'Inner color',
                'required' => false,
                'widget_type'  => ""
            ))
            ->add('fabriccolor', null, array(
                'attr' => array('class'=>'labelchoice'),
                'label_attr' => array('class'=>'mylabelclass control-label'),
                'label' => 'Fabric color',
                'required' => false,
                'widget_type'  => ""
            ))
            ->add('rimdiameter', null, array(
                'attr' => array('class'=>'labelchoice'),
                'label_attr' => array('class'=>'mylabelclass control-label'),
                'label' => 'Rim Diameter',
                'required' => false,
                'widget_type'  => ""
            ))
            ->add('rimwidth', null, array(
                
                'attr' => array('class'=>'labelchoice'),
                'label_attr' => array('class'=>'mylabelclass control-label'),
                'label' => 'Rim width',
                'required' => false,
                'widget_type'  => ""
            ))
            ->add('wallwidth', null, array(
                'attr' => array('class'=>'labelchoice'),
                'label_attr' => array('class'=>'mylabelclass control-label'),
                'label' => 'Wall width',
                'required' => false,
                'widget_type'  => ""
            ))
            ->add('maxwalldiameter', null, array(
                'attr' => array('class'=>'labelchoice'),
                'label_attr' => array('class'=>'mylabelclass control-label'),
                'label' => 'Max diameter',
                'required' => false,
                'widget_type'  => ""
            ))
            ->add('bottomwidth', null, array(
                'attr' => array('class'=>'labelchoice'),
                'label_attr' => array('class'=>'mylabelclass control-label'),
                'label' => 'Bottom width',
                'required' => false,
                'widget_type'  => ""
            ))
            ->add('height', null, array(
                'attr' => array('class'=>'labelchoice'),
                'label_attr' => array('class'=>'mylabelclass control-label'),
                'label' => 'Height',
                'required' => false,
                'widget_type'  => ""
            ))
            ->add('basediameter', null, array(
                'attr' => array('class'=>'labelchoice'),
                'label_attr' => array('class'=>'mylabelclass control-label'),
                'label' => 'Base diameter',
                'required' => false,
                'widget_type'  => ""
            ))
            ->add('restored', null, array(
                'attr' => array('class'=>'labelchoice'),
                'label_attr' => array('class'=>'mylabelclass control-label'),
                'label' => 'Restored',
                'required' => false,
                'widget_type'  => ""
            ))
            ->add('datation', null, array(
                'attr' => array('class'=>'labelchoice'),
                'label_attr' => array('class'=>'mylabelclass control-label'),
                'label' => 'Date',
                'required' => false,
                'widget_type'  => ""
            ))
            ->add(
                'save',
                'submit',
                [
                    'attr' => array('class'=>'btn btn-success'),
                    'icon'       => 'ok-sign',
                    'icon_inverted' => true,
                ]
            )
            ->add(
                'reset',
                'reset',
                [
                    'attr' => array('class'=>'btn'),
                    'icon'       => 'remove-sign',
                    'icon_inverted' => true,
                ]
            )
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
