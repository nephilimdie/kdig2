<?php

namespace Kdig\OrientBundle\Form\Potteryvoc;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class VocPotteryDecorationinType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('decorationoption', null, array(
                'label' => 'Decoration Option',
                'required' => false,
                'widget_type'  => "inline"
            ))
            ->add('color', null, array(
                'label' => 'Color',
                'required' => false,
                'widget_type'  => "inline"
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Kdig\OrientBundle\Entity\Potteryvoc\VocPotteryDecorationin'
        ));
    }

    public function getName()
    {
        return 'kdig_orientbundle_potteryvoc_vocpotterydecorationintype';
    }
}
