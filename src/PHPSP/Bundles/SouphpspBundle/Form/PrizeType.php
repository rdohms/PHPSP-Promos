<?php

namespace PHPSP\Bundles\SouphpspBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use PHPSP\Bundles\SouphpspBundle\Entity\Choice\PrizePictures;

class PrizeType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('quantity')
                
            ->add('picture', 'choice', array(
                'choice_list' => new PrizePictures(),
            ))
                
            ->add('sponsor', 'entity', array(
                'class' => 'PHPSP\Bundles\SouphpspBundle\Entity\Sponsor'
            ))
                
            ->add('description')
        ;
    }

    public function getName()
    {
        return 'phpsp_bundles_souphpspbundle_prizetype';
    }
}
