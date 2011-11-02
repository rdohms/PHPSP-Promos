<?php

namespace PHPSP\Bundles\SouphpspBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ChallengeType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('prize')
            ->add('description')
            ->add('qtdWinners')
            ->add('startDate')
            ->add('endDate')
            ->add('sponsor')
            ->add('project')
        ;
    }

    public function getName()
    {
        return 'phpsp_bundles_souphpspbundle_challengetype';
    }
}
