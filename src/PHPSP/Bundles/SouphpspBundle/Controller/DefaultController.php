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
        
        $stats = $this->getEM()->getRepository('SouphpspBundle:Contribution')->getStats();
        
        $stats['top_project'] = array_shift($stats['top_project']);
        
        return array(
            'ranking'  => $ranking['ranking'],
            'userData' => $ranking['userData'],
            'sponsors' => $sponsors,
            'stats'    => $stats,
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
