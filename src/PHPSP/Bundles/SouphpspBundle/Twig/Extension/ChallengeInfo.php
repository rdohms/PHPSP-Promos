<?php

namespace PHPSP\Bundles\SouphpspBundle\Twig\Extension;

class ChallengeInfo extends \Twig_Extension
{
    /**
     * @var Registry
     */
    protected $doctrine;
    
    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
    }
    
    public function getName()
    {
        return 'Challenge Information';
    }

    public function getFunctions()
    {
        return array(
            'challengeActiveCount' => new \Twig_Function_Method($this, 'activeCount'),
        );
    }
    
    public function activeCount()
    {
        $em = $this->doctrine->getEntityManager();
        
        return $em->getRepository('SouphpspBundle:Challenge')->countActiveChallenges();
    }

}