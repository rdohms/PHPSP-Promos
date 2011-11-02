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
use Doctrine\Common\Collections\ArrayCollection;


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
        $challenge = $this->getEM()->getRepository('SouphpspBundle:Challenge')->find($id);

        if (!$challenge) {
            throw $this->createNotFoundException('Desafio não encontrado.');
        }

        //Get user contributions
        $uid = $this->getLoggedUser()->id;
        $form   = $this->createForm(new ChallengeSubmitType(), array(), array('uid' => $uid));
        
        return array(
            'challenge'    => $challenge,
            'form'         => $form->createView(),
            'uid'          => $uid,
            'participants' => $this->getUniqueParticipants($challenge),
            'message'      => null,
        );
    }

    /**
     * @Route("/{id}/save-submission", name="challenge_save_submission")
     * @Method("post")
     * @Template("SouphpspBundle:Challenge:submit.html.twig")
     */
    public function saveSubmissionAction($id)
    {
        $challenge = $this->getEM()->getRepository('SouphpspBundle:Challenge')->find($id);
        

        
        $request = $this->getRequest();
        $uid = $this->getLoggedUser()->id;
        
        $form   = $this->createForm(new ChallengeSubmitType(), array(), array('uid' => $uid));
        $form->bindRequest($request);

        if ($form->isValid() && $challenge->getEndDate()->format('U') > time()) {

            $contribution = $form->get('contribution')->getData();
            $challenge->appendContribution($contribution);
            
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($challenge);
            $em->flush();
            
            return $this->redirect($this->generateUrl('challenge_submit', array('id' => $challenge->getId())));
            
        }

        $message = ($challenge->getEndDate()->format('U') < time())? 'Tempo expirado. Participação não concluida com sucesso.':null;

        
        return array(
            'challenge'    => $challenge,
            'form'         => $form->createView(),
            'uid'          => $uid,
            'participants' => $this->getUniqueParticipants($challenge),
            'message'      => $message
        );
    }
    
    /**
     * Filters contributions for unique participants
     * 
     * @param Challenge $challenge
     * @return ArrayCollection 
     */
    protected function getUniqueParticipants($challenge)
    {
        //Filter duplicated participants
        $participants = new ArrayCollection();
        $challenge->getContributions()->map( function ($c) use ($participants) { 
            
            if ( ! $participants->contains($c->getUserId())){
                $participants->add($c->getUserId());
            }
            
            } );
            
        return $participants;
    }
}
