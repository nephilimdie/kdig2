<?php

namespace Kdig\ArchaeologicalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Kdig\ArchaeologicalBundle\Form\MatrixType;

class UsType extends AbstractType
{
    protected $areaid;
    protected $id;
    
    public function __construct($areaid, $id)
    {
        $this->areaid = $areaid;
        $this->id = $id;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $idarea = $this->areaid;
        $idus = $this->id;
        
        if ($idarea != null)
            $builder->add('area', 'entity', array(
                'widget_control_group_attr' => array('class'=>'span6'),
                'widget_controls_attr' => array('class'=>'labeltext'),
                'label_attr' => array('class'=>'mylabelclass'),
                'class' => 'KdigArchaeologicalBundle:Area',
                'query_builder' => function($repository) use ($idarea) {
                    $expr = new \Doctrine\ORM\Query\Expr();
                    return $repository->createQueryBuilder('p')
                        ->setParameter('idarea', $idarea)
                        ->add('where', ($expr->in('p.id', ':idarea')))
                        ->orderBy('p.name', 'ASC'); 
                },
                'property' => 'name',
                'label' => 'Area',
                'help_block'  => 'Select your excavation area'
            ));
        else
            $builder->add('area');
        
        $builder
            ->add('site', 'entity', array(
                'widget_control_group_attr' => array('class'=>'span6'),
                'widget_controls_attr' => array('class'=>'labeltext'),
                'label_attr' => array('class'=>'mylabelclass'),
                'class' => 'KdigArchaeologicalBundle:Site',
                'query_builder' => function($repository) {
                    return $repository->createQueryBuilder('p')
                        ->orderBy('p.name', 'DESC'); 
                },
//                'attr' => array('sigla' => 'myValue'),
                'label' => 'Excavation campaign',
                'help_block'  => 'Select your Campaign'
            ))
            ->add('typeus', 'entity', array(
                'widget_control_group_attr' => array('class'=>'span6'),
                'widget_controls_attr' => array('class'=>'labeltext'),
                'label_attr' => array('class'=>'mylabelclass'),
                'class' => 'KdigArchaeologicalBundle:VocUsType',
                'required' => true,
                'label' => 'Type',
                'help_block'  => 'Select your kind of US'
            ))
            ->add('name',null, array(
                'widget_control_group_attr' => array('class'=>'span6'),
                'widget_controls_attr' => array('class'=>'labeltext'),
                'label_attr' => array('class'=>'mylabelclass'),
                'required' => true,
                'label' => 'Field Name',
                'help_block'  => 'Automatic loaded from DB. Or change with your'
            ))
            ->add('remarks',null, array(
                'widget_control_group_attr' => array('class'=>'span12'),
                'widget_controls_attr' => array('class'=>'labeltext'),
                'label_attr' => array('class'=>'mylabelclass'),
            ))
            ->add('relationsfrom', 'collection', array(
                'widget_control_group_attr' => array('class'=>'span12'),
                'widget_controls_attr' => array('class'=>'labelchoice'),
                'label_attr' => array('class'=>'mylabelclass'),
                'type' => new MatrixType($idarea), 
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'widget_add_btn' => array('label' => 'Add Relationship between Us', 'attr' => array('class' => 'btn btn-primary')),
                'options' => array( // options for collection fields
                    'widget_remove_btn' => array('label' => 'remove', 'attr' => array('class' => 'btn btn-primary')),
                    'attr' => array('class' => 'span3'),
                    'widget_control_group_attr' => array('class'=>'span12'),
                    'label_attr' => array('class'=>'mylabelclass'),
                    'widget_control_group' => false,
                ),
                'label' => 'Matrix',
                'required' => false,
                'show_child_legend' => true
            ))
            ->add('media', 'entity', array(
                'widget_control_group_attr' => array('class'=>'span12'),
                'widget_controls_attr' => array('class'=>'labelchoice'),
                'label_attr' => array('class'=>'mylabelclass'),
                'class' => 'KdigMediaBundle:Media',
                'required' => false,
                'multiple' => true
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Kdig\ArchaeologicalBundle\Entity\Us'
        ));
    }

    public function getName()
    {
        return 'kdig_archaeologicalbundle_ustype';
    }
}
