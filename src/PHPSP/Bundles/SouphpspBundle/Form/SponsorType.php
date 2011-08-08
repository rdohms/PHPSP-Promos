<?php

namespace PHPSP\Bundles\SouphpspBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class SponsorType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('site')
            ->add('logo')
            ->add('category')
        ;
    }

    public function getName()
    {
        return 'phpsp_bundles_souphpspbundle_sponsortype';
    }
}
