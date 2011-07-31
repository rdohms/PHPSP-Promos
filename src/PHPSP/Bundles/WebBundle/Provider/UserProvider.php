<?php

namespace PHPSP\Bundles\WebBundle\Provider;

use Symfony\Component\Security\Core\Exception\UsernameNotFoundException,
    Symfony\Component\Security\Core\Exception\UnsupportedUserException,
    Symfony\Component\Security\Core\User\UserProviderInterface,
    Symfony\Component\Security\Core\User\UserInterface,
    Symfony\Bridge\Doctrine\Security\User\EntityUserProvider;

class UserProvider extends EntityUserProvider
{
    /**
     * @var \TwitterOAuth 
     */
    protected $twitter;

    public function __construct($em, $class, $property = null)
    {
        
        parent::__construct($em, $class, $property);
    }

}