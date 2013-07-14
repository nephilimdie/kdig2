<?php

namespace Kdig\OrientBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormError;

class PotteryFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', 'filter_number_range')
            ->add('remarks', 'filter_text')
            ->add('created', 'filter_date_range')
            ->add('updated', 'filter_date_range')
            ->add('isActive', 'filter_choice')
            ->add('isPublic', 'filter_choice')
            ->add('isDelete', 'filter_choice')
            ->add('tcode', 'filter_text')
            ->add('typecontext', 'filter_number_range')
            ->add('outercolor', 'filter_text')
            ->add('innercolor', 'filter_text')
            ->add('fabriccolor', 'filter_text')
            ->add('rimdiameter', 'filter_text')
            ->add('rimwidth', 'filter_text')
            ->add('wallwidth', 'filter_text')
            ->add('maxwalldiameter', 'filter_text')
            ->add('bottomwidth', 'filter_text')
            ->add('height', 'filter_text')
            ->add('basediameter', 'filter_text')
            ->add('restored', 'filter_text')
            ->add('datation', 'filter_text')
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
        return 'kdig_orientbundle_potteryfiltertype';
    }
}
