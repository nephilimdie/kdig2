<?php

namespace Kdig\OrientBundle\Form\Potteryvoc;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class VocPotterySurfacetratoutType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('color')
            ->add('pottery')
            ->add('vocsurfacetratoption')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Kdig\OrientBundle\Entity\Potteryvoc\VocPotterySurfacetratout'
        ));
    }

    public function getName()
    {
        return 'kdig_orientbundle_potteryvoc_vocpotterysurfacetratouttype';
    }
}
