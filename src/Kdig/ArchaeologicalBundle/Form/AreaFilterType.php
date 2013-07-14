<?php

namespace Kdig\ArchaeologicalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormError;

class AreaFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', 'filter_number_range')
            ->add('name', 'filter_text')
            ->add('remarks', 'filter_text')
            ->add('created', 'filter_date_range')
            ->add('updated', 'filter_date_range')
            ->add('isActive', 'filter_choice')
            ->add('isPublic', 'filter_choice')
            ->add('isDelete', 'filter_choice')
            ->add('fromrefbucket', 'filter_number_range')
            ->add('torefbucket', 'filter_number_range')
            ->add('fromrefus', 'filter_number_range')
            ->add('torefus', 'filter_number_range')
        ;

        $listener = function(FormEvent $event)
        {
            // Is data empty?
            foreach ($event->getData() as $data) {
                if(is_array($data)) {
                    foreach ($data as $subData) {
                        if(!empty($subData)) return;
                    }
                }
                else {
                    if(!empty($data)) return;
                }
            }

            $event->getForm()->addError(new FormError('Filter empty'));
        };
        $builder->addEventListener(FormEvents::POST_BIND, $listener);
    }

    public function getName()
    {
        return 'kdig_archaeologicalbundle_areafiltertype';
    }
}
