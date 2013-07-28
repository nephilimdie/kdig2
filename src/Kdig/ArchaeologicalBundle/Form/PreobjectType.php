<?php

namespace Kdig\ArchaeologicalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PreobjectType extends AbstractType
{
    protected $bucketid;
    protected $inobject;
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
            ->add('bucket', 'entity', array(
                'class' => 'KdigArchaelogicalBundle:Bucket',
                'query_builder' => function($repository) use ($bucketid, $usid) {
                    $expr = new \Doctrine\ORM\Query\Expr();
                    $idiota = $repository->createQueryBuilder('p')
                        ->setParameter('buckets', $bucketid)
                        ->add('where', ($expr->in('p.id', ':buckets')))
                            ->orderBy('p.name', 'ASC'); 
                        if ($usid != null) 
                            $idiota->setParameter('usid', $usid)->andWhere($expr->in('p.us', ':usid'));
                    return $idiota;
                }
            ))
            ->add('name')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Kdig\ArchaeologicalBundle\Entity\Preobject'
        ));
    }

    public function getName()
    {
        return 'kdig_archaeologicalbundle_preobjecttype';
    }
}
