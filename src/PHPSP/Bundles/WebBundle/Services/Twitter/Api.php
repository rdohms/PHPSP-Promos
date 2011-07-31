<?php

namespace PHPSP\Bundles\WebBundle\Services\Twitter;

class Api
{
    /**
     * @var TwitterOAuth
     */
    protected $twitter;
    
    protected $cache;
    
    public function __construct(\TwitterOAuth $twitter, $cache = null)
    {
        $this->twitter = $twitter;
        $this->cache = $cache;
    }
    
    public function usersShow($user_id = null, $screen_name = null, $parameters = array())
    {
        $q = $user_id ?: $screen_name;
        
        $qField = ($user_id === null)? 'screen_name':'user_id';
        
        $parameters[$qField] = $q;
        
        $userData = $this->twitter->get('users/show', $parameters);
        
        if ($this->twitter->http_code != 200) {
            $this->storeLastError();
        }
        
        return ($this->twitter->http_code === 200)? $userData:new \stdClass();
    }
    
    protected function storeLastError()
    {
        $this->error = new Error($this->twitter);
    }
}