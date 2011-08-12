<?php

namespace PHPSP\Bundles\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        $uid = $this->get('security.context')->getToken()->getUser()->getUsername();
        
        $twApi = $this->get('phpsp.twitter.api');
        
        $userData = $twApi->usersShow($uid);
        
        return array('name' => $userData->screen_name);
    }
}