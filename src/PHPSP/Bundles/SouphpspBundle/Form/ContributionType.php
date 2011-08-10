<?php

namespace PHPSP\Bundles\SouphpspBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ContributionType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('userId', 'hidden')
                
            ->add('project', 'entity', array(
                'class' => 'PHPSP\Bundles\SouphpspBundle\Entity\Project',
                'required' => false,
                'empty_value' => "Outro projeto...",
                'label' => 'Projeto'
            ))
            
            ->add('type', 'choice', array(
                'choice_list' => new \PHPSP\Bundles\SouphpspBundle\Entity\Choice\ContributionTypes(),
                'label' => 'Tipo de contribuição'
            ))
                
            ->add('description', null, array(
                'label' => 'Descreva sua contribuição'
            ))
                
            ->add('reference', null, array(
                'label' => 'Link para contribuição'
            ))
                
            ->add('notes', null, array(
                'label' => 'Observações'
            ))
            ->add('status')
            ->add('mentorId')
            ->add('dateAdded')
            ->add('dateRevised')
            ->add('reasonDenied')
                
            ->add('projectOther', 'text', array('required' => false, 'label' => 'Outro projeto (não listado)'))
            ->add('typeOther', 'text', array('required' => false, 'label' => 'Outro tipo (não listado)'))
        ;
    }

    public function getName()
    {
        return 'phpsp_bundles_souphpspbundle_contributiontype';
    }
}
