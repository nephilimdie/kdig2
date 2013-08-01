<?php

namespace Kdig\ArchaeologicalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MatrixType extends AbstractType
{
    protected $areaid;
    protected $usid;
    
    public function __construct($areaid, $usid = null)
    {
        $this->areaid = $areaid;
        $this->usid = $usid;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $idarea = $this->areaid;
        
        $builder
            ->add('typerelation',null, array(
                'widget_control_group_attr' => array('class'=>'span4'),
                'widget_controls_attr' => array('class'=>'mycontrolsclass'),
                'label_attr' => array('class'=>'mylabelclass'),
            ))
            ->add('touss', 'genemu_jqueryselect2_entity', array(
                'class' => 'KdigArchaeologicalBundle:Us',
                'query_builder' => function($repository) use ($idarea) {
                    $expr = new \Doctrine\ORM\Query\Expr();
                    $idiota = $repository->createQueryBuilder('p')
                        ->setParameter('idarea', $idarea)
                        ->add('where', ($expr->in('p.area', ':idarea')))
//                            ->where('p.area = :idarea')
                        ->orderBy('p.name', 'ASC'); 
                    
                    return $idiota;
                },
                'required' => true,
                'label' => 'SU Definition',
                'help_block'  => 'Select SU',
                'widget_control_group_attr' => array('class'=>'span4'),
                'widget_controls_attr' => array('class'=>'mycontrolsclass'),
                'label_attr' => array('class'=>'mylabelclass'),
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Kdig\ArchaeologicalBundle\Entity\Matrix'
        ));
    }

    public function getName()
    {
        return 'kdig_archaeologicalbundle_matrixtype';
    }
}
