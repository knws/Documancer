<?php

namespace Totalcan\DocumancerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;

class FrontpageController extends Controller
{
    public function indexAction()
    {
        return $this->render('TotalcanDocumancerBundle:Wizard:wizard.html.twig', array(  
        ));
    }
}
