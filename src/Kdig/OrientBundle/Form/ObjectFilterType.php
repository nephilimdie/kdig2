<?php

namespace Kdig\OrientBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormError;

class ObjectFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', 'filter_number_range')
            ->add('number', 'filter_number_range')
            ->add('remarks', 'filter_text')
            ->add('created', 'filter_date_range')
            ->add('updated', 'filter_date_range')
            ->add('isActive', 'filter_choice')
            ->add('isPublic', 'filter_choice')
            ->add('isDelete', 'filter_choice')
            ->add('isphotographed', 'filter_choice')
            ->add('drawned', 'filter_choice')
            ->add('fragments', 'filter_text')
            ->add('inscription', 'filter_text')
            ->add('dateoofcontext', 'filter_text')
            ->add('height', 'filter_text')
            ->add('lenght', 'filter_text')
            ->add('width', 'filter_text')
            ->add('thickness', 'filter_text')
            ->add('diameter', 'filter_text')
            ->add('perforationdiameter', 'filter_text')
            ->add('weight', 'filter_text')
            ->add('bibliography', 'filter_text')
            ->add('restorationdate', 'filter_date_range')
            ->add('analysisdate', 'filter_date_range')
            ->add('analysisreport', 'filter_text')
            ->add('location', 'filter_text')
            ->add('museum_acquisition', 'filter_text')
            ->add('museum_acquisition_notes', 'filter_text')
            ->add('exhibition_history', 'filter_text')
            ->add('itaremarks', 'filter_text')
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
        return 'kdig_orientbundle_objectfiltertype';
    }
}
