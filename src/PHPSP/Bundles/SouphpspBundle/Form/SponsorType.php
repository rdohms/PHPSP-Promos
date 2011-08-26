<?php

namespace PHPSP\Bundles\SouphpspBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use PHPSP\Bundles\SouphpspBundle\Entity\Choice\SponsorPictures;

class SponsorType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('site')
            ->add('logo', 'choice', array(
                'choice_list' => new SponsorPictures(),
            ))
            ->add('category')
        ;
    }

    public function getName()
    {
        return 'phpsp_bundles_souphpspbundle_sponsortype';
    }
}
