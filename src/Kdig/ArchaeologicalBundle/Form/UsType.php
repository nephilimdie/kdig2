<?php

namespace Kdig\ArchaeologicalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('sigla')
            ->add('remarks')
            ->add('area')
            ->add('site')
            ->add('typeus')
            ->add('media', 'entity', array(
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
