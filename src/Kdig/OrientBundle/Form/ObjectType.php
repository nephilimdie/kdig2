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
            ->add('class')
            ->add('type')
            ->add('material')
            ->add('technique')
            ->add('decoration')
            ->add('preservation')
            ->add('dateobject')
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
