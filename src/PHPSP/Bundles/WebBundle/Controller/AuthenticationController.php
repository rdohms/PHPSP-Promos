<?php

namespace PHPSP\Bundles\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class AuthenticationController extends Controller
{
    /**
     * @Route("/login")
     * @Template()
     */
    public function loginAction()
    {
        
        if ($this->get('security.context')->getToken()->isAuthenticated()) {
            return $this->redirect('/');
        }
                
        
        return array();
    }

}
