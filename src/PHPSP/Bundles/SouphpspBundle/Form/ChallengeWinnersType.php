<?php

namespace PHPSP\Bundles\SouphpspBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ChallengeWinnersType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('winners', 'entity', array(
                    'class'         => 'SouphpspBundle:Contribution',
                    'query_builder' => function ($er) use ($options) { 
                                        
                                        $qb = $er->createQueryBuilder('c');
                                        $qb->andWhere('c.status != ?1');
                                        $qb->setParameter(1, 0);

                                        $qb->orderBy('c.dateRevised', 'DESC');
                                        $qb->orderBy('c.dateAdded', 'DESC');
                                        return $qb; },
                    'label'         => "Escolha os vencedores",
                    'multiple'      => true,
                    'expanded'      => true,
            ));
    }

    public function getName()
    {
        return 'phpsp_bundles_souphpspbundle_challengewinnerstype';
    }
    
    public function getDefaultOptions(array $options)
    {
        return $options;
    }

}


