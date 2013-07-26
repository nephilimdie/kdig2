<?php

namespace Kdig\ArchaeologicalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UsType extends AbstractType
{
    protected $areaid;
    protected $id;
    
    public function __construct($areaid, $id)
    {
        $this->areaid = $areaid;
        $this->id = $id;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $idarea = $this->areaid;
        $idus = $this->id;
        
        if ($idarea != null)
            $builder->add('area', 'entity', array(
                'class' => 'KdigArchaeologicalBundle:Area',
                'query_builder' => function($repository) use ($idarea) {
                    $expr = new \Doctrine\ORM\Query\Expr();
                    return $repository->createQueryBuilder('p')
                        ->setParameter('idarea', $idarea)
                        ->add('where', ($expr->in('p.id', ':idarea')))
                        ->orderBy('p.name', 'ASC'); 
                },
                'property' => 'name',
                'label' => 'Area',
                'help'  => 'Select your excavation area'
            ));
        else
            $builder->add('area');
        
        $builder
            ->add('site', 'entity', array(
                'class' => 'KdigArchaeologicalBundle:Site',
                'query_builder' => function($repository) {
                    return $repository->createQueryBuilder('p')
                        ->orderBy('p.name', 'DESC'); 
                },
//                'attr' => array('sigla' => 'myValue'),
                'label' => 'Excavation campaign',
            ))
            ->add('name')
            ->add('typeus')
            ->add('sigla')
            ->add('remarks')
            ->add('media', 'entity', array(
                'class' => 'KdigMediaBundle:Media',
                'required' => false,
                'multiple' => true
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Kdig\ArchaeologicalBundle\Entity\Us'
        ));
    }

    public function getName()
    {
        return 'kdig_archaeologicalbundle_ustype';
    }
}
