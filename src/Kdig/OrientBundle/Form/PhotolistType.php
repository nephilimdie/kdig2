<?php

namespace Kdig\OrientBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PhotolistType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fromnumber', null, array(
                'widget_control_group_attr' => array('class'=>'span2'),
                'widget_controls_attr' => array('class'=>'labelchoice'),
                'label_attr' => array('class'=>'mylabelclass'),
                'label' => 'Reference Number',
                'required' => true,
            ))
            ->add('tonumber', null, array(
                'widget_control_group_attr' => array('class'=>'span2'),
                'widget_controls_attr' => array('class'=>'labelchoice'),
                'label_attr' => array('class'=>'mylabelclass'),
                'label' => 'Reference Number',
                'required' => true,
            ))
            ->add('vocmachine', 'entity', array(
                'widget_control_group_attr' => array('class'=>'span2'),
                'class' => 'Kdig\OrientBundle\Entity\VocMachine',
                'property' => 'name'
            ))
            ->add('object', 'entity', array(
                'widget_control_group_attr' => array('class'=>'span2'),
                'class' => 'Kdig\OrientBundle\Entity\Object',
                'property' => 'number',
                'attr'=> array('class'=>''),
                'required' => false
            ))
            ->add('pottery', 'entity', array(
                'widget_control_group_attr' => array('class'=>'span2'),
                'class' => 'Kdig\OrientBundle\Entity\Pottery',
                'property' => 'prepottery.name',
                'attr'=> array('class'=>''),
                'required' => false
            ))
            ->add('sample', 'entity', array(
                'widget_control_group_attr' => array('class'=>'span2'),
                'class' => 'Kdig\OrientBundle\Entity\Sample',
                'property' => 'presample.name',
                'attr'=> array('class'=>''),
                'required' => false
                
            ))
            ->add('us', 'entity', array(
                'widget_control_group_attr' => array('class'=>'span2'),
                'class' => 'Kdig\ArchaeologicalBundle\Entity\Us',
                'attr'=> array('class'=>''),
                'required' => false
            ))
            ->add('area', 'entity', array(
                'widget_control_group_attr' => array('class'=>'span2'),
                'class' => 'Kdig\ArchaeologicalBundle\Entity\Area',
                'property' => 'name',
                'attr'=> array('class'=>''),
                'required' => false
            ))
            ->add('remarks', null, array(
                'widget_control_group_attr' => array('class'=>'span12'),
                'widget_controls_attr' => array('class'=>'labelchoice'),
                'label_attr' => array('class'=>'mylabelclass'),
                'label' => 'Remarks',
                'required' => false,
                'widget_type'  => ""
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Kdig\OrientBundle\Entity\Photolist'
        ));
    }

    public function getName()
    {
        return 'kdig_orientbundle_photolisttype';
    }
}
