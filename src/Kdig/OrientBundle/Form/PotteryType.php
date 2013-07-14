<?php

namespace Kdig\OrientBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PotteryType extends AbstractType
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
            ->add('tcode')
            ->add('typecontext')
            ->add('outercolor')
            ->add('innercolor')
            ->add('fabriccolor')
            ->add('rimdiameter')
            ->add('rimwidth')
            ->add('wallwidth')
            ->add('maxwalldiameter')
            ->add('bottomwidth')
            ->add('height')
            ->add('basediameter')
            ->add('restored')
            ->add('datation')
            ->add('prepottery')
            ->add('class')
            ->add('shape')
            ->add('rim')
            ->add('neck')
            ->add('wall')
            ->add('upperwall')
            ->add('lowerwall')
            ->add('base')
            ->add('handle')
            ->add('handleposition')
            ->add('spout')
            ->add('spoutposition')
            ->add('preservation')
            ->add('technique')
            ->add('firing')
            ->add('inclusion')
            ->add('inclusionsize')
            ->add('inclusionfrequency')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Kdig\OrientBundle\Entity\Pottery'
        ));
    }

    public function getName()
    {
        return 'kdig_orientbundle_potterytype';
    }
}
