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
use PHPSP\Bundles\SouphpspBundle\Form\ChallengeSubmitType;


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
     * @Route("/{id}/submit", name="challenge_submit")
     * @Template()
     */
    public function submitAction($id)
    {
        //TODO: if ended abort submit
        
        $challenge = $this->getEM()->getRepository('SouphpspBundle:Challenge')->find($id);

        if (!$challenge) {
            throw $this->createNotFoundException('Desafio não encontrado.');
        }

        //Get user contributions
        $uid = $this->getLoggedUser()->id;
        $form   = $this->createForm(new ChallengeSubmitType(), array('challenge' => $id), array('uid' => $uid));
        
        return array(
            'challenge' => $challenge,
            'form'      => $form->createView()
        );
    }

    /**
     * @Route("/save-submission", name="challenge_save_submission")
     * @Template()
     */
    public function saveSubmissionAction($id)
    {

    }
    
}
