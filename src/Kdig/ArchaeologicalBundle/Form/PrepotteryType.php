<?php

namespace Kdig\ArchaeologicalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PrepotteryType extends AbstractType
{
    protected $bucketid;
    
    public function __construct($bucketid = null)
    {
        $this->bucketid = $bucketid;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $bucketid = $this->bucketid;
        
        $builder
            ->add('bucket', 'entity', array(
                'class' => 'KdigArchaelogicalBundle:Bucket',
                'query_builder' => function($repository) use ($bucketid) {
                    $expr = new \Doctrine\ORM\Query\Expr();
                    $idiota = $repository->createQueryBuilder('p')
                        ->setParameter('buckets', $bucketid)
                        ->add('where', ($expr->in('p.id', ':buckets')))
                        ->orderBy('p.name', 'ASC'); 
                    return $idiota;
                }
            ))
            ->add('name')
            ->add('remarks')
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
