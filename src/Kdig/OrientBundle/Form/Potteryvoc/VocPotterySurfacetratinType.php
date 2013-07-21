<?php

namespace Kdig\OrientBundle\Form\Potteryvoc;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class VocPotterySurfacetratinType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('color', null, array(
                'label' => 'Color',
                'required' => false,
                'widget_type'  => "inline"
            ))
            ->add('vocsurfacetratoption', null, array(
                'label' => 'Treatment Surface Option',
                'required' => false,
                'widget_type'  => "inline"
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Kdig\OrientBundle\Entity\Potteryvoc\VocPotterySurfacetratin'
        ));
    }

    public function getName()
    {
        return 'kdig_orientbundle_potteryvoc_vocpotterysurfacetratintype';
    }
}
