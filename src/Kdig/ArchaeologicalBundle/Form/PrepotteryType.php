<?php

namespace Kdig\ArchaeologicalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PrepotteryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('remarks')
            ->add('bucket', 'genemu_jqueryselect2_entity', array(
                'class' => 'Kdig\OrientBundle\Entity\Bucket',
                'property' => 'name',
                'placeholder'=>'select bucket',
                'minimumInputLength'=>2
            ))
            ->add('media')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Kdig\ArchaeologicalBundle\Entity\Prepottery'
        ));
    }

    public function getName()
    {
        return 'kdig_archaeologicalbundle_prepotterytype';
    }
}
