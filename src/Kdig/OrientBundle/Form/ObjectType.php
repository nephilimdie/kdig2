<?php

namespace Kdig\OrientBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Kdig\ArchaeologicalBundle\Form\PreobjectType;

class ObjectType extends AbstractType
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
            ->add('preobject', new PreobjectType($bucketid, $usid), array(
                'attr'=> array('class'=>'row-fluid')
            ))
            ->add('number', null, array(
                'widget_control_group_attr' => array('class'=>'col-md-4'),
                'widget_controls_attr' => array('class'=>'labelchoice'),
                'label_attr' => array('class'=>'mylabelclass'),
                'label' => 'Reference Number',
                'required' => true,
            ))
            ->add('class', 'genemu_jqueryselect2_entity', array(
                'widget_control_group_attr' => array('class'=>'col-md-4'),
                'class' => 'Kdig\OrientBundle\Entity\Objectvoc\VocObjClass',
                'property' => 'name'
            ))
            ->add('type', 'genemu_jqueryselect2_entity', array(
                'widget_control_group_attr' => array('class'=>'col-md-4'),
                'class' => 'Kdig\OrientBundle\Entity\Objectvoc\VocObjType',
                'property' => 'name'
            ))
            ->add('material', 'genemu_jqueryselect2_entity', array(
                'widget_control_group_attr' => array('class'=>'col-md-4'),
                'class' => 'Kdig\OrientBundle\Entity\Objectvoc\VocObjMaterial',
                'property' => 'name'
            ))
            ->add('technique', 'genemu_jqueryselect2_entity', array(
                'widget_control_group_attr' => array('class'=>'col-md-4'),
                'class' => 'Kdig\OrientBundle\Entity\Objectvoc\VocObjTechnique',
                'property' => 'name'
            ))
            ->add('decoration', 'genemu_jqueryselect2_entity', array(
                'widget_control_group_attr' => array('class'=>'col-md-4'),
                'class' => 'Kdig\OrientBundle\Entity\Objectvoc\VocObjDecoration',
                'property' => 'name'
            ))
            ->add('preservation', 'genemu_jqueryselect2_entity', array(
                'widget_control_group_attr' => array('class'=>'col-md-4'),
                'class' => 'Kdig\OrientBundle\Entity\Objectvoc\VocObjPreservation',
                'property' => 'name'
            ))
            ->add('fragments', null, array(
                'widget_control_group_attr' => array('class'=>'col-md-4'),
                'widget_controls_attr' => array('class'=>'labelchoice'),
                'label_attr' => array('class'=>'mylabelclass'),
                'required' => true,
                'widget_type'  => ""
            ))
            ->add('height', null, array(
                'widget_control_group_attr' => array('class'=>'col-md-4'),
                'widget_controls_attr' => array('class'=>'labelchoice'),
                'label_attr' => array('class'=>'mylabelclass'),
                'required' => true,
                'widget_type'  => ""
            ))
            ->add('lenght', null, array(
                'widget_control_group_attr' => array('class'=>'col-md-4'),
                'widget_controls_attr' => array('class'=>'labelchoice'),
                'label_attr' => array('class'=>'mylabelclass'),
                'required' => true,
                'widget_type'  => ""
            ))
            ->add('width', null, array(
                'widget_control_group_attr' => array('class'=>'col-md-4'),
                'widget_controls_attr' => array('class'=>'labelchoice'),
                'label_attr' => array('class'=>'mylabelclass'),
                'required' => true,
                'widget_type'  => ""
            ))
            ->add('thickness', null, array(
                'widget_control_group_attr' => array('class'=>'col-md-4'),
                'widget_controls_attr' => array('class'=>'labelchoice'),
                'label_attr' => array('class'=>'mylabelclass'),
                'required' => true,
                'widget_type'  => ""
            ))
            ->add('diameter', null, array(
                'widget_control_group_attr' => array('class'=>'col-md-4'),
                'widget_controls_attr' => array('class'=>'labelchoice'),
                'label_attr' => array('class'=>'mylabelclass'),
                'required' => true,
                'widget_type'  => ""
            ))
            ->add('perforationdiameter', null, array(
                'widget_control_group_attr' => array('class'=>'col-md-4'),
                'widget_controls_attr' => array('class'=>'labelchoice'),
                'label_attr' => array('class'=>'mylabelclass'),
                'label' => 'Perforation Diameter',
                'required' => false,
                'widget_type'  => ""
            ))
            ->add('weight', null, array(
                'widget_control_group_attr' => array('class'=>'col-md-4'),
                'widget_controls_attr' => array('class'=>'labelchoice'),
                'label_attr' => array('class'=>'mylabelclass'),
                'label' => 'Weight',
                'required' => false,
                'widget_type'  => ""
            ))
            ->add('remarks', null, array(
                'widget_control_group_attr' => array('class'=>'col-md-12'),
                'widget_controls_attr' => array('class'=>'labelchoice'),
                'label_attr' => array('class'=>'mylabelclass'),
                'label' => 'Remarks',
                'required' => false,
                'widget_type'  => ""
            ))
                
//            ->add('isphotographed')
//            ->add('drawned')
//            ->add('inscription')
//            ->add('dateoofcontext')
//            ->add('bibliography')
//            ->add('restorationdate')
//            ->add('analysisdate')
//            ->add('analysisreport')
//            ->add('location')
//            ->add('museum_acquisition')
//            ->add('museum_acquisition_notes')
//            ->add('exhibition_history')
//            ->add('itaremarks')
//            ->add('dateobject', 'genemu_jqueryselect2_entity', array(
//                'class' => 'Kdig\OrientBundle\Entity\Objectvoc\VocObjDate',
//                'property' => 'name',
//                'required' => false
//            ))
//            ->add('media', 'entity', array(
//                'class' => 'KdigMediaBundle:Media',
//                'required' => false,
//                'multiple' => true
//            ))
        ;
        $builder->setAttribute('class', 'col-md-4');
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Kdig\OrientBundle\Entity\Object'
        ));
    }

    public function getName()
    {
        return 'kdig_orientbundle_objecttype';
    }
}
