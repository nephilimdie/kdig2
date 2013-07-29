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
            ->add('remarks')
            ->add('created')
            ->add('updated')
            ->add('isActive')
            ->add('isPublic')
            ->add('isDelete')
            ->add('fromnumber')
            ->add('tonumber')
            ->add('vocmachine')
            ->add('object')
            ->add('pottery')
            ->add('sample')
            ->add('us')
            ->add('area')
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
