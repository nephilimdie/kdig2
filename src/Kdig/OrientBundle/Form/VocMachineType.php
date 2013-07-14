<?php

namespace Kdig\OrientBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class VocMachineType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('sigla')
            ->add('remarks')
            ->add('created')
            ->add('updated')
            ->add('isActive')
            ->add('isPublic')
            ->add('isDelete')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Kdig\OrientBundle\Entity\VocMachine'
        ));
    }

    public function getName()
    {
        return 'kdig_orientbundle_vocmachinetype';
    }
}
