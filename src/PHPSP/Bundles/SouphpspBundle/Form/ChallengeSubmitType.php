<?php

namespace PHPSP\Bundles\SouphpspBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ChallengeSubmitType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('contribution', 'entity', array(
                    'class'         => 'SouphpspBundle:Contribution',
                    'query_builder' => function ($er) use ($options) { 
                                        $qb = $er->createQueryBuilder('c');
                                        $qb->where('c.userId = ?0');
                                        $qb->andWhere('c.status != ?1');

                                        $uid = isset($options['uid'])? $options['uid']:null;
                                        $qb->setParameter(0, $uid);
                                        $qb->setParameter(1, 0);

                                        $qb->orderBy('c.dateRevised', 'DESC');
                                        $qb->orderBy('c.dateAdded', 'DESC');
                                        return $qb; },
                    'label'         => "Escolha uma de suas contribuições"
            ));
    }

    public function getName()
    {
        return 'phpsp_bundles_souphpspbundle_challengesubmittype';
    }
    
    public function getDefaultOptions(array $options)
    {
        return $options;
    }

}


