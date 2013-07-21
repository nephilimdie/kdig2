<?php

namespace Kdig\OrientBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BucketType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('remarks')
            ->add('imageName')
            ->add('us')
            ->add('media', 'entity', array(
                'class' => 'KdigMediaBundle:Media',
                'required' => false,
                'multiple' => true
            ))
            ->add('bucketsheet')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Kdig\OrientBundle\Entity\Bucket'
        ));
    }

    public function getName()
    {
        return 'kdig_orientbundle_buckettype';
    }
}
