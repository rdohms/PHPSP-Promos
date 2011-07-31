<?php

namespace PHPSP\Bundles\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class BlockController extends Controller
{
    /**
     * @Template()
     */
    public function topBarAction()
    {
        $uid = $this->get('security.context')->getToken()->getUser();
        
        $twApi = $this->get('phpsp.twitter.api');
        
        $userData = $twApi->usersShow($uid);
        
        return array(
            'isLogged' => ($uid),
            'loggedUser' => $userData
        );
    }
}