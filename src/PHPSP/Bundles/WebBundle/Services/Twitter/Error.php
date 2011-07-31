<?php

namespace PHPSP\Bundles\WebBundle\Services\Twitter;

class Error
{
    protected $httpCode;
    
    protected $httpStatus;
    
    public function __construct(\TwitterOAuth $twitterOauth)
    {
        $this->httpCode = $twitterOauth->http_code;
        $this->httpStatus = $twitterOauth->http_header['status'];
    }
}