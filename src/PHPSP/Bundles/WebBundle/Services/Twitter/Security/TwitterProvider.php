<?php

namespace PHPSP\Bundles\WebBundle\Services\Twitter\Security;

use FOS\TwitterBundle\Security\Authentication\Provider\TwitterProvider as FOSTwitterProvider;

/**
 * Overrides FOS\TwitterBundle and implements custom userProvider
 */
class TwitterProvider extends FOSTwitterProvider
{
    /**
     * Custom Constructor
     * @param FOS\TwitterBundle\Services\Twitter $twitter
     * @param Symfony\Component\DependencyInjection\Container $container
     * @param \PHPSP\Bundles\WebBundle\Provider\Twitter\UserProvider $userProvider
     * @param \Symfony\Component\Security\Core\User\UserChecker $userChecker 
     */
    public function __construct($twitter, $container, $userProvider = null, $userChecker = null)
    {
        
        if ($userProvider == null) {
            $userProvider = new \PHPSP\Bundles\WebBundle\Provider\Twitter\UserProvider();
            $userChecker = new \Symfony\Component\Security\Core\User\UserChecker();
        }
            
        parent::__construct($twitter, $container, $userProvider, $userChecker);
    }
    
    /**
     * Calls UserProvider to refresh user.
     * 
     * @param User $user
     * @return User 
     */
    public function refreshUser($user)
    {
        return $this->userProvider->refreshUser($user);
    }
}