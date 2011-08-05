<?php

namespace PHPSP\Bundles\SouphpspBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('site')
            ->add('repository')
            ->add('howtocontribute')
            ->add('contactName')
            ->add('contactEmail')
            ->add('contactTwitter')
            ->add('about')
            ->add('whereToHelp')
        ;
    }

    public function getName()
    {
        return 'phpsp_bundles_souphpspbundle_projecttype';
    }
}
