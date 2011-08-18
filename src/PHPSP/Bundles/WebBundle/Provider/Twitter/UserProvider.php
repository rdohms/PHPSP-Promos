<?php

namespace PHPSP\Bundles\WebBundle\Provider\Twitter;

use Symfony\Component\Security\Core\User\UserProviderInterface,
    Symfony\Component\Security\Core\User\User,
    Symfony\Component\Security\Core\User\UserInterface;

/**
 * Custom UserProvider
 * 
 * Populates and retrieves Roles for Users
 * This is a very minimalist implementation
 * just to allow for access control
 * 
 * @todo Implement DB User objects with complementary data
 */
class UserProvider implements UserProviderInterface
{
    protected $admins = array('9453502', '15416900');
    
    /**
     * {@inheritDoc}
     */
    public function loadUserByUsername($uid)
    {
        
        $roles = array('ROLE_USER');
        
        if (in_array($uid, $this->admins)) {
            $roles[] = 'ROLE_ADMIN';
        }
        
        $user = new User($uid, '', $roles);
        
        return $user;
    }

    /**
     * {@inheritDoc}
     */
    public function refreshUser(UserInterface $user)
    {
        return $user;
    }

    /**
     * {@inheritDoc}
     */
    public function supportsClass($class)
    {
        return true;
    }

}