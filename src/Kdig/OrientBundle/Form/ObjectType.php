<?php

namespace Kdig\OrientBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Kdig\ArchaeologicalBundle\Form\PreobjectType;

class ObjectType extends AbstractType
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
            ->add('number', null, array(
                'attr'=> array('class'=>'span3')
            ))
            ->add('preobject', new PreobjectType($bucketid), array(
                'attr'=> array('class'=>'row-fluid')
            ))
            ->add('class', 'genemu_jqueryselect2_entity', array(
                'class' => 'Kdig\OrientBundle\Entity\Objectvoc\VocObjClass',
                'property' => 'name',
                'attr'=> array('class'=>'span3')
            ))
            ->add('type', 'genemu_jqueryselect2_entity', array(
                'class' => 'Kdig\OrientBundle\Entity\Objectvoc\VocObjType',
                'property' => 'name',
                'attr'=> array('class'=>'span3')
            ))
            ->add('material', 'genemu_jqueryselect2_entity', array(
                'class' => 'Kdig\OrientBundle\Entity\Objectvoc\VocObjMaterial',
                'property' => 'name',
                'attr'=> array('class'=>'span3')
            ))
            ->add('technique', 'genemu_jqueryselect2_entity', array(
                'class' => 'Kdig\OrientBundle\Entity\Objectvoc\VocObjTechnique',
                'property' => 'name',
                'attr'=> array('class'=>'span3')
            ))
            ->add('decoration', 'genemu_jqueryselect2_entity', array(
                'class' => 'Kdig\OrientBundle\Entity\Objectvoc\VocObjDecoration',
                'property' => 'name',
                'attr'=> array('class'=>'span3')
            ))
            ->add('preservation', 'genemu_jqueryselect2_entity', array(
                'class' => 'Kdig\OrientBundle\Entity\Objectvoc\VocObjPreservation',
                'property' => 'name',
                'attr'=> array('class'=>'span3')
            ))
            ->add('fragments', null, array(
                'attr'=> array('class'=>'span3')
            ))
            ->add('height', null, array(
                'attr'=> array('class'=>'span3')
            ))
            ->add('lenght', null, array(
                'attr'=> array('class'=>'span3')
            ))
            ->add('width', null, array(
                'attr'=> array('class'=>'span3')
            ))
            ->add('thickness', null, array(
                'attr'=> array('class'=>'span3')
            ))
            ->add('diameter', null, array(
                'attr'=> array('class'=>'span3')
            ))
            ->add('perforationdiameter', null, array(
                'attr'=> array('class'=>'span3')
            ))
            ->add('weight', null, array(
                'attr'=> array('class'=>'span3')
            ))
            ->add('remarks', null, array(
                'attr'=> array('class'=>'span12')
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
