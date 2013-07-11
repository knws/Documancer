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
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('TotalcanDocumancerBundle:User')->getUsersList();

        for($i=0; $i<=sizeof($users)-1; $i++) {
            $usersArray[] = array(
                'id' => $users[$i]->getId(),
                'variables' => $users[$i]->getVariables()
            );
        }

        return $this->render('TotalcanDocumancerBundle:Frontpage:index.html.twig', array( 'users' => $usersArray
        ));
    }
}
