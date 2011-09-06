<?php

namespace PHPSP\Bundles\SouphpspBundle\Controller;

use PHPSP\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use PHPSP\Bundles\SouphpspBundle\Entity\Prize;
use PHPSP\Bundles\SouphpspBundle\Form\PrizeType;

/**
 * Stats controller.
 *
 * @Route("/souphpsp/admin/stats")
 */
class AdminStatsController extends Controller
{
    
    /**
     * Lists all Prize entities.
     *
     * @Route("/", name="souphpsp_admin_stats")
     * @Template()
     */
    public function indexAction()
    {
        $chartBuilder = $this->get('souphpsp.chart.builder');
        
        $chartOptions = array(
            '3d'     => true,
            'legend' => true,
            'size'   => '450x250',
            'color'  => '1B75BB'
        );
        
        $charts = array();
        $charts['top_projects'] = $chartBuilder->getActiveProjectGraph($chartOptions);
        $charts['top_types'] = $chartBuilder->getContributionTypeGraph($chartOptions);
        
        $chartOptionsForStatus = $chartOptions;
        unset($chartOptionsForStatus['color']);
        $charts['contribution_status'] = $chartBuilder->getContributionStatusGraph($chartOptionsForStatus);
        
        return array(
            'charts' => $charts
        );
    }
 
}