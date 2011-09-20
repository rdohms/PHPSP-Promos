<?php

namespace PHPSP\Bundles\SouphpspBundle\Controller;

use PHPSP\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    
    /**
     * @Route("/souphpsp/x")
     */
    public function xAction()
    {
        $oauth = new \TwitterOAuth('qPLsh4YhO2Ui8KmM6vRtw', 'CbtjJPSD1yxxJfbbr4TPKX7K0UCExnffk5Qg', '18179550-Z6V17Ly1tvyOEiqCjuq1NfenI71FacvFrlqYT8Bqb', 'CkS51WZMERauimVxZBOxVQVLtBeDzIZCFLzCQpGzlg');
        
        $res = $oauth->post('http://api.twitter.com/1/direct_messages/new.json', array('screen_name' => 'rdohms', 'text' => 'mytext'));
        var_dump($res);
        
        return new \Symfony\Component\HttpFoundation\Response();
    }   
    
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
            'charts'   => $this->getCharts()
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
    
    protected function getCharts()
    {
        $chartBuilder = $this->get('souphpsp.chart.builder');
        
        $chartOptions = array(
            '3d'     => true,
            'legend' => true,
            'size'   => '280x150',
            'color'  => '1B75BB'
        );
        
        $charts = array();
        $charts['top_projects'] = $chartBuilder->getActiveProjectGraph($chartOptions);
        $charts['top_types'] = $chartBuilder->getContributionTypeGraph($chartOptions);
        
        return $charts;
    }
}
