<?php

namespace Kdig\ArchaeologicalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PrepotteryType extends AbstractType
{
    protected $bucketid;
    protected $us;
    
    public function __construct($bucketid, $usid = null)
    {
        $this->bucketid = $bucketid;
        $this->us = $usid;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $bucketid = $this->bucketid;
        $usid = $this->us;
        
        $builder
            ->add('bucket', 'genemu_jqueryselect2_entity', array(
                'class' => 'KdigOrientBundle:Bucket',
                'query_builder' => function($repository) use ($bucketid, $usid) {
                    $expr = new \Doctrine\ORM\Query\Expr();
                    $idiota = $repository->createQueryBuilder('p')
                        ->setParameter('buckets', $bucketid)
                        ->add('where', ($expr->in('p.id', ':buckets')))
                            ->orderBy('p.name', 'ASC'); 
                        if ($usid != null) 
                            $idiota->setParameter('usid', $usid)->andWhere($expr->in('p.us', ':usid'));
                    return $idiota;
                },
                'horizontal_input_wrapper_class' => 'col-lg-4',
                'attr' => array('class'=>'mycontrolsclass'),
                'label_attr' => array('class'=>'mylabelclass'),
            ))
            ->add('name',null,array(
                'horizontal_input_wrapper_class' => 'col-lg-4',
                'attr' => array('class'=>'mycontrolsclass'),
                'label_attr' => array('class'=>'mylabelclass'),
                ))
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
