<?php

namespace PHPSP\Bundles\WebBundle\Services\Graph;

use GoogleChartGenerator;

class Service
{
    public function __construct()
    {
        
    }
    
    public function pieChart($title, $arcs, $options)
    {
        $chartOptions = array('title' => $title);
        $chartOptions = array_merge($chartOptions, $options);
        
        $chart = new GoogleChartGenerator\Chart\PieChart\PieChart($chartOptions);
        
        foreach($arcs as $arc){
            $arcObject = new \GoogleChartGenerator\Chart\PieChart\Arc($arc['data'], $arc['options']);
            $chart->addData($arcObject);
        }
        
        return $chart;
    }
}