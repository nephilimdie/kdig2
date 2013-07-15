<?php

namespace Kdig\OrientBundle\Form\Objectvoc;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class VocObjPreservationType extends AbstractType
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
            'data_class' => 'Kdig\OrientBundle\Entity\Objectvoc\VocObjPreservation'
        ));
    }

    public function getName()
    {
        return 'kdig_orientbundle_objectvoc_vocobjpreservationtype';
    }
}
