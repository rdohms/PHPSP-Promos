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
        $projectData = $this->getEM()->getRepository('SouphpspBundle:Contribution')->getCountByProject();
        $typeData = $this->getEM()->getRepository('SouphpspBundle:Contribution')->getCountByType();
        
        $chartOptions = array(
            '3d'     => true,
            'legend' => true,
            'size'   => '450x250',
            'color'  => '1B75BB'
        );
        
        $charts = array();
        $chartService = $this->get('phpsp.chart');
        $charts['top_projects'] = $chartService->pieChart(
                                        'Projetos mais ativos', 
                                        $this->buildProjectPieChartData($projectData), 
                                        $chartOptions 
                                  );
        
        $charts['top_types'] = $chartService->pieChart(
                                        'Tipos de contribuições', 
                                        $this->buildTypePieChartData($typeData), 
                                        $chartOptions 
                                );
        
        return array(
            'charts' => $charts
        );
        
        
    }
 
    /**
     *
     * @param type $resultSet
     * @return array 
     */
    protected function buildProjectPieChartData($resultSet)
    {
        $arcs = array();
        foreach($resultSet as $result) {
            $arc = array(
                'data' => $result['pCount'],
                'options' => array( 
                    'title' => (string) $result[0]->getProject() . " (".$result['pCount'].")",
                )
            );
            $arcs[] = $arc;
        }
        
        return $arcs;
    }
    
    /**
     *
     * @param type $resultSet
     * @return array 
     */
    protected function buildTypePieChartData($resultSet)
    {
        $arcs = array();
        foreach($resultSet as $result) {
            $arc = array(
                'data' => $result['cCount'],
                'options' => array( 
                    'title' => $result[0]->getType() . " (".$result['cCount'].")",
                )
            );
            $arcs[] = $arc;
        }
        
        return $arcs;
    }
}