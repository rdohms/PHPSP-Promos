<?php

namespace PHPSP\Bundles\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\User\User;

class BlockController extends Controller
{
    /**
     * @Template()
     */
    public function topBarAction()
    {
        $token = $this->get('security.context')->getToken();
        
        if ($token === null) {
            return array('isLogged' => false, 'loggedUser' => new \stdClass());
        }
        
        //Get data is Authenticated
        if ($token->isAuthenticated() && $token->getUser() instanceof User) {
            $uid = $token->getUser()->getUsername();
            
            $twApi = $this->get('phpsp.twitter.api');
            $userData = $twApi->usersShow($uid);
            
            return array(
                'isLogged' => $token->isAuthenticated(),
                'loggedUser' => $userData
            );
        }
        
        return array(
            'isLogged' => false,
            'loggedUser' => new \stdClass()
        );
    }
}