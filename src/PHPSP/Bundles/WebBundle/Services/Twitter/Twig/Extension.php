<?php

namespace PHPSP\Bundles\WebBundle\Services\Twitter\Twig;

class Extension extends \Twig_Extension
{
    /**
     * @var PHPSP\Bundles\WebBundle\Services\Twitter\Api
     */
    protected $api;
    
    public function __construct($twitterApi)
    {
        $this->api = $twitterApi;
    }
    
    public function getName()
    {
        return 'twig_twitter_api';
    }
    
    public function getFunctions()
    {
        return array(
            'getTwitterInfo' => new \Twig_Function_Method($this, 'getUserInfo')
        );
    }


    public function getUserInfo($uid)
    {
        return $this->api->usersShow($uid);
    }
    
}