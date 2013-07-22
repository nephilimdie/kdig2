<?php

namespace Kdig\ArchaeologicalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PreobjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, array(
                'attr'=> array('class'=>'span3')
            ))
            ->add('remarks', null, array(
                'attr'=> array('class'=>'span12')
            ))
            ->add('bucket', null, array(
                'attr'=> array('class'=>'span3')
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Kdig\ArchaeologicalBundle\Entity\Preobject'
        ));
    }

    public function getName()
    {
        return 'kdig_archaeologicalbundle_preobjecttype';
    }
}
