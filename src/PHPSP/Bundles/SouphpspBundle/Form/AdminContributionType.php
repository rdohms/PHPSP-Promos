<?php

namespace PHPSP\Bundles\SouphpspBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class AdminContributionType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('status', 'choice', array(
                  'choices' => array( 1 => 'Aprovar', 0 => 'Rejeitar'),
                  'label' => 'Ação'
            ))
            ->add('reasonDenied', null, array('label' => "Motivo da rejeição"))
        ;
    }

    public function getName()
    {
        return 'phpsp_bundles_souphpspbundle_admincontributiontype';
    }
}
