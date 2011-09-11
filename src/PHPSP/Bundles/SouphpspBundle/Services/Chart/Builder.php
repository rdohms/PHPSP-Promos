<?php

namespace PHPSP\Bundles\SouphpspBundle\Services\Chart;

use \PHPSP\Bundles\SouphpspBundle\Entity\Contribution;

/**
 * Builds charts based on repository queries
 */
class Builder
{
    /**
     * @var Doctrine\ORM\EntityManager 
     */
    protected $em;
    
    /**
     * @var PHPSP\Bundles\WebBundle\Services\Chart\Service 
     */
    protected $chart;
    
    /**
     * @var array
     */
    protected $defaultOptions;
    
    public function __construct($doctrine, $chart)
    {
        $this->em = $doctrine->getEntityManager();
        $this->chart = $chart;
        $this->defaultOptions = array(
            '3d'     => true,
            'legend' => true,
        );
    }
    
    /**
     * Chart of most contributed to projects
     * 
     * @param array $options
     * @return type 
     */
    public function getActiveProjectGraph($options, $criteria = array())
    {
        $options = $this->getMergedOptions($options);
        
        $data = $this->em->getRepository('SouphpspBundle:Contribution')->getCountByProject($criteria);
        
        $processedData = $this->parseProjectData($data);
        
        return $this->chart->pieChart('Projetos mais ativos', $processedData, $options);
    }
    
    /**
     * Chart od the most frequent contribution types
     * 
     * @param array $options
     * @return type 
     */
    public function getContributionTypeGraph($options, $criteria = array())
    {
        $options = $this->getMergedOptions($options);
        
        $data = $this->em->getRepository('SouphpspBundle:Contribution')->getCountByType($criteria);
        
        $processedData = $this->parseContributionTypeData($data);
        
        return $this->chart->pieChart('Tipos de contribuição', $processedData, $options);
    }
    
    /**
     * Chart od the most frequent contribution types
     * 
     * @param array $options
     * @return type 
     */
    public function getContributionStatusGraph($options, $criteria = array())
    {
        $options = $this->getMergedOptions($options);
        
        $data = $this->em->getRepository('SouphpspBundle:Contribution')->getCountByStatus($criteria);
        
        $processedData = $this->parseContributionStatusData($data);
        
        return $this->chart->pieChart('Estado das contribuições', $processedData, $options);
    }
    
    /**
     * Parses resultset into charting data
     * 
     * @param type $resultSet
     * @return array 
     */
    protected function parseContributionTypeData($resultSet)
    {
        $entries = array();
        foreach($resultSet as $result) {
            $entry = array(
                'data' => $result['cCount'],
                'options' => array( 
                    'title' => $result[0]->getType() . " (".$result['cCount'].")",
                )
            );
            $entries[] = $entry;
        }
        
        return $entries;
    }
    
    /**
     * Parses resultset into charting data
     * 
     * @param type $resultSet
     * @return array 
     */
    protected function parseContributionStatusData($resultSet)
    {
        $entries = array();
        foreach($resultSet as $result) {
            
            switch($result[0]->getStatus()){
                case Contribution::APPROVED:
                    $name  = "Aprovadas";
                    $color = "5F9941"; 
                    break;
                case Contribution::PENDING:
                    $name  = "Em avaliação";
                    $color = "999126"; 
                    break;
                case Contribution::DENIED:
                    $name  = "Rejeitadas";
                    $color = "99432E"; 
                    break;
            }
            
            $entry = array(
                'data' => $result['cCount'],
                'options' => array( 
                    'title' => $name . " (".$result['cCount'].")",
                    'color' => $color
                )
            );
            $entries[] = $entry;
        }
        
        return $entries;
    }
    
    /**
     * Parses resultset into charting data.
     * 
     * @param type $resultSet
     * @return array 
     */
    protected function parseProjectData($resultSet)
    {
        $entries = array();
        foreach($resultSet as $result) {
            $entry = array(
                'data' => $result['pCount'],
                'options' => array( 
                    'title' => (string) $result[0]->getProject() . " (".$result['pCount'].")",
                )
            );
            $entries[] = $entry;
        }
        
        return $entries;
    }
    
    protected function getMergedOptions($options)
    {
        return array_merge($this->defaultOptions, $options);
    }
}