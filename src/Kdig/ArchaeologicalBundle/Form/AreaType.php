<?php

namespace Kdig\ArchaeologicalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AreaType extends AbstractType
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
            ->add('fromrefbucket')
            ->add('torefbucket')
            ->add('fromrefus')
            ->add('torefus')
            ->add('type')
            ->add('media', 'entity', array(
                'class' => 'KdigOrientBundle:Potteryvoc\Media',
                'required' => false,
                'multiple' => true
            ))
            ->add('groups')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Kdig\ArchaeologicalBundle\Entity\Area'
        ));
    }

    public function getName()
    {
        return 'kdig_archaeologicalbundle_areatype';
    }
}
