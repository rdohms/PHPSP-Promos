<?php

namespace PHPSP\Bundles\WebBundle\Services\Twitter;

use Doctrine\Common\Cache\Cache;

class Api
{
    /**
     * @var TwitterOAuth
     */
    protected $twitter;
    
    /**
     * @var Doctrine\Common\Cache\Cache
     */
    protected $cache;
    
    /**
     * Constructor
     * 
     * @param \TwitterOAuth $twitter
     * @param Cache $cache 
     */
    public function __construct(\TwitterOAuth $twitter, Cache $cache = null)
    {
        $this->twitter = $twitter;
        $this->cache = $cache;
    }
    
    /**
     * Maps /users/show
     * 
     * @param string $user_id
     * @param string $screen_name
     * @param array $parameters
     * @return stdClass 
     */
    public function usersShow($user_id = null, $screen_name = null, $parameters = array())
    {
        $q = $user_id ?: $screen_name;
        
        $qField = ($user_id === null)? 'screen_name':'user_id';
        
        $parameters[$qField] = $q;
        
        //Check cache
        $cacheKey = 'twitter.api-' . $qField . "_" . $q;
        if ($this->cache !== null && $this->cache->contains($cacheKey)) {
            return $this->cache->fetch($cacheKey);
        }
        
        $userData = $this->twitter->get('users/show', $parameters);
        
        if ($this->twitter->http_code != 200) {
            $this->storeLastError();
        }
        
        //SAve to cache
        if ($this->cache !== null) {
            $this->cache->save($cacheKey, $userData, 1296000);
        }
        
        return ($this->twitter->http_code === 200)? $userData:new \stdClass();
    }
    
    /**
     * Stores the last error message given
     */
    protected function storeLastError()
    {
        $this->error = new Error($this->twitter);
    }
    
}