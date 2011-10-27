<?php

namespace PHPSP\Bundles\SouphpspBundle\Controller;

use PHPSP\Controller\Controller;
use Symfony\Component\Form\FormError;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use PHPSP\Bundles\SouphpspBundle\Entity\Contribution;
use PHPSP\Bundles\SouphpspBundle\Form\ContributionType;
use PHPSP\Bundles\SouphpspBundle\Entity\Project;


/**
 * Contribution controller.
 *
 * @Route("/souphpsp/challenge")
 */
class ChallengeController extends Controller
{

    /**
     * Lists all Challenges 
     *
     * @Route("/", name="challenge_list")
     * @Template()
     */
    public function indexAction()
    {
        $active = $this->getEM()->getRepository('SouphpspBundle:Challenge')->findActiveChallenges();
        $recent = $this->getEM()->getRepository('SouphpspBundle:Challenge')->findRecentChallenges();

        return array(
            'active' => $active,
            'recent' => $recent,
         );
    }

    /**
     * @Route("/{id}/show", name="challenge_show")
     * @Template()
     */
    public function showAction($id)
    {

        $challenge = $this->getEM()->getRepository('SouphpspBundle:Challenge')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Desafio não encontrado.');
        }

        return array(
            'challenge'      => $challenge,
        );
    }
    
}
