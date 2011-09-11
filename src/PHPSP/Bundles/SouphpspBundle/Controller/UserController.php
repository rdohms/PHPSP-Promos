<?php

namespace PHPSP\Bundles\SouphpspBundle\Controller;

use PHPSP\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * User controller.
 *
 * @Route("/souphpsp")
 */
class UserController extends Controller
{
    /**
     * @Route("/u/{username}", name="user_page")
     * @Template()
     */
    public function userAction($username)
    {
        $twApi = $this->get('phpsp.twitter.api');
        
        //Get data for selected user
        $user = $twApi->usersShow(null, $username);
        
        //Skip if we can't fnd this user on twitter
        if ( ! isset($user->id)) {
            $this->redirect('/souphpsp');
        }

        $stats = $this->getEM()->getRepository('SouphpspBundle:Contribution')->getStatsByUser($user->id);

        return array(
            'contribs' => $this->getContribsByStatus($user),
            'user'     => $user,
            'stats'    => $stats,
            'charts'   => $this->getUserCharts($user->id)
        );
        
    }
    
    protected function getContribsByStatus($user)
    {
        $dbContributions = $this->getEM()->getRepository('SouphpspBundle:Contribution')->getAllUserContributions($user->id);
        
        $contributions = array(array(), array(), array());
        foreach ($dbContributions as $contrib)
        {
            $contributions[$contrib->getStatus()][] = $contrib;
        }
        
        return $contributions;
    }
    
    protected function getUserCharts($userId)
    {
        $chartBuilder = $this->get('souphpsp.chart.builder');
        
        $chartOptions = array(
            '3d'     => true,
            'legend' => true,
            'size'   => '300x150',
            'color'  => '1B75BB'
        );
        
        //Build Criteria for Graphs
        $criteria = array();
        $criteria['userId'] = array(
            'field'    => 'userId',
            'operator' => '=',
            'value'    => $userId
        );
        $criteria['status'] = array(
            'field'    => 'status',
            'operator' => '!=',
            'value'    => 999
        );
        
        
        $charts = array();
        $charts['projects'] = $chartBuilder->getActiveProjectGraph($chartOptions, $criteria);
        $charts['types'] = $chartBuilder->getContributionTypeGraph($chartOptions, $criteria);
        
        $chartOptionsForStatus = $chartOptions;
        $criteriaForStatus = $criteria;
        unset($chartOptionsForStatus['color']);
        unset($criteriaForStatus['status']);
        $charts['status'] = $chartBuilder->getContributionStatusGraph($chartOptionsForStatus, $criteriaForStatus);
        
        return $charts;
    }
    
}
