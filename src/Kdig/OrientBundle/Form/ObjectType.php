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
            ->add('preobject', new PreobjectType($bucketid))
            ->add('number')
            ->add('remarks')
            ->add('isphotographed')
            ->add('drawned')
            ->add('fragments')
            ->add('inscription')
            ->add('dateoofcontext')
            ->add('height')
            ->add('lenght')
            ->add('width')
            ->add('thickness')
            ->add('diameter')
            ->add('perforationdiameter')
            ->add('weight')
            ->add('bibliography')
            ->add('restorationdate')
            ->add('analysisdate')
            ->add('analysisreport')
            ->add('location')
            ->add('museum_acquisition')
            ->add('museum_acquisition_notes')
            ->add('exhibition_history')
            ->add('itaremarks')
            ->add('class', 'genemu_jqueryselect2_entity', array(
                'class' => 'Kdig\OrientBundle\Entity\Objectvoc\VocObjClass',
                'property' => 'name',
            ))
            ->add('type', 'genemu_jqueryselect2_entity', array(
                'class' => 'Kdig\OrientBundle\Entity\Objectvoc\VocObjType',
                'property' => 'name',
            ))
            ->add('material', 'genemu_jqueryselect2_entity', array(
                'class' => 'Kdig\OrientBundle\Entity\Objectvoc\VocObjMaterial',
                'property' => 'name',
            ))
            ->add('technique', 'genemu_jqueryselect2_entity', array(
                'class' => 'Kdig\OrientBundle\Entity\Objectvoc\VocObjTechnique',
                'property' => 'name',
            ))
            ->add('decoration', 'genemu_jqueryselect2_entity', array(
                'class' => 'Kdig\OrientBundle\Entity\Objectvoc\VocObjDecoration',
                'property' => 'name',
            ))
            ->add('preservation', 'genemu_jqueryselect2_entity', array(
                'class' => 'Kdig\OrientBundle\Entity\Objectvoc\VocObjPreservation',
                'property' => 'name',
            ))
            ->add('dateobject', 'genemu_jqueryselect2_entity', array(
                'class' => 'Kdig\OrientBundle\Entity\Objectvoc\VocObjDate',
                'property' => 'name',
            ))
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
