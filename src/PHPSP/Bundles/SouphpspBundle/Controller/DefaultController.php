<?php

namespace PHPSP\Bundles\SouphpspBundle\Controller;

use PHPSP\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/souphpsp")
     * @Template()
     */
    public function indexAction()
    {
        $ranking = $this->getTopContributors();

        $sponsors = $this->getEM()->getRepository('SouphpspBundle:Sponsor')->getSponsorsInOrder();
        
        $prizes = $this->getEM()->getRepository('SouphpspBundle:Prize')->findAll();
        
        $stats = $this->getEM()->getRepository('SouphpspBundle:Contribution')->getStats();
        
        $stats['top_project'] = array_shift($stats['top_project']);
        
        return array(
            'ranking'  => $ranking['ranking'],
            'userData' => $ranking['userData'],
            'sponsors' => $sponsors,
            'prizes'   => $prizes,
            'stats'    => $stats,
        );
    }
    
    /**
     * @Route("souphpsp/u/{username}", name="user_page")
     * @Template()
     */
    public function userAction($username)
    {
        $twApi = $this->get('phpsp.twitter.api');
        $user = $twApi->usersShow(null, $username);
        
        if ( ! isset($user->id)) {
            $this->redirect('/souphpsp');
        }

        $contributions = $this->getEM()->getRepository('SouphpspBundle:Contribution')->getUserContributions($user->id);
        $stats = $this->getEM()->getRepository('SouphpspBundle:Contribution')->getStatsByUser($user->id);

        return array(
            'contribs' => $contributions,
            'user'     => $user,
            'stats'    => $stats
        );
        
    }
    
    /**
     * @todo create local userEntity with user data and add to join
     */
    protected function getTopContributors()
    {
        $contribRepo = $this->getEM()->getRepository('SouphpspBundle:Contribution');
        /* @var $contribRepo PHPSP\Bundles\SouphpspBundle\Entity\ContributionRepository */
        
        $ranking = $contribRepo->getTopContributors(10);
        
        //Retrieve user info
        $userInfo = array();
        $twApi = $this->get('phpsp.twitter.api');
        
        foreach ($ranking as $contrib) {
            $userInfo[$contrib[0]->getUserId()] = $twApi->usersShow($contrib[0]->getUserId());
        }
        
        return array( 'ranking' => $ranking, 'userData' => $userInfo );
    }
    
    
}
