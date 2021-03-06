<?php

namespace Kdig\ArchaeologicalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class VocAreaTypeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
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
            'data_class' => 'Kdig\ArchaeologicalBundle\Entity\VocAreaType'
        ));
    }

    public function getName()
    {
        return 'kdig_archaeologicalbundle_vocareatypetype';
    }
}
