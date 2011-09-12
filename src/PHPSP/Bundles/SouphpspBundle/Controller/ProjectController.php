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
class ProjectController extends Controller
{
    /**
     * @Route("/p/{id}", name="project_page")
     * @Template()
     */
    public function projectAction($id)
    {
        $project = $this->getEM()->find('SouphpspBundle:Project', $id);
        
        //Skip if we can't find
        if ( $project === null) {
            $this->redirect('/souphpsp');
        }

        return array(
            'contribs' => $this->getContribsByStatus($project),
            'project'  => $project,
            'charts'   => $this->getProjectCharts($project)
        );
        
    }
    
    protected function getContribsByStatus($project)
    {
        $dbContributions = $this->getEM()->getRepository('SouphpspBundle:Contribution')->getAllProjectContributions($project);
        
        $contributions = array(array(), array(), array());
        foreach ($dbContributions as $contrib)
        {
            $contributions[$contrib->getStatus()][] = $contrib;
        }
        
        return $contributions;
    }
    
    protected function getProjectCharts($project)
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
        $criteria['project'] = array(
            'field'    => 'project',
            'operator' => '=',
            'value'    => $project
        );
        $criteria['status'] = array(
            'field'    => 'status',
            'operator' => '!=',
            'value'    => 999
        );
        
        
        $charts = array();
        $charts['types'] = $chartBuilder->getContributionTypeGraph($chartOptions, $criteria);
        
        $chartOptionsForStatus = $chartOptions;
        $criteriaForStatus = $criteria;
        unset($chartOptionsForStatus['color']);
        unset($criteriaForStatus['status']);
        $charts['status'] = $chartBuilder->getContributionStatusGraph($chartOptionsForStatus, $criteriaForStatus);
        
        return $charts;
    }
}