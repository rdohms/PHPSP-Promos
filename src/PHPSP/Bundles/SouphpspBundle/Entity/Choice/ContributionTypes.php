<?php

namespace PHPSP\Bundles\SouphpspBundle\Entity\Choice;

use Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceListInterface;

class ContributionTypes implements ChoiceListInterface
{
    public function getChoices()
    {
        return array(
            'Bug Fix'       => 'Bug Fix',
            'Nova Feature'  => 'Nova Funcionalidade',
            'Documentação'  => 'Documentação',
            'Melhoria'      => 'Melhoria / Refatoração',
            'Tradução'      => 'Tradução',
            'Testes'        => 'Testes',
            'Outro'         => 'Outro'
        );
    }

}