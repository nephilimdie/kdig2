<?php

namespace Kdig\OrientBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BucketsheetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('remarks')
            ->add('isread')
            ->add('isdrawn')
            ->add('isnumbered')
            ->add('isfiled')
            ->add('isphotographed')
            ->add('bucket')
            ->add('media')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Kdig\OrientBundle\Entity\Bucketsheet'
        ));
    }

    public function getName()
    {
        return 'kdig_orientbundle_bucketsheettype';
    }
}
