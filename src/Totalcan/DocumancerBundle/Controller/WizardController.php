<?php

namespace Totalcan\DocumancerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class WizardController extends Controller
{
    public function clientAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('TotalcanDocumancerBundle:User')->getUsersList();

        $usr= $this->get('security.context')->getToken()->getUser();
        //$clients = $em->getRepository('TotalcanDocumancerBundle:Client')->findByUserIdAndClientId($usr->getId(), $id);
        $clients = $em->getRepository('TotalcanDocumancerBundle:Client')->find($id);
        $designs = $em->getRepository('TotalcanDocumancerBundle:Design')->findByUserId(1);
//
//        $clientsArray = array(
//            'id' => $clients[0]->getId(),
//            //'variables' => json_decode($clients[0]->getVariables(), 1),
//            'variables' => $clients[0]->getVariables(),
//            'date' => $clients[0]->getDate(),
//            'userId' => $clients[0]->getUserId()->getUsername(),
//            'exId' => $clients[0]->getExId(),
//        );

        $form = $this->createForm($this->get('form.type.clientAjax'), $clients);

        $engine = $this->container->get('templating');
        $clientForm = $engine->render('TotalcanDocumancerBundle:Wizard:clientForm.html.twig', array( 'form' => $form->createView()));

        for($i=0; $i<=sizeof($designs)-1; $i++) {
            $designsArray[] = array(
                'id' => $designs[$i]->getId(),
                'variables' => $designs[$i]->getVariables(),
                'design' => $designs[$i]->getDesign(),
                'date' => $designs[$i]->getDate(),
                'title' => $designs[$i]->getTitle()
            );
        }

        return $this->render('TotalcanDocumancerBundle:Wizard:client.html.twig', array(
//            'client' => $clientsArray,
            'clientForm' => $clientForm,

            'users' => $users,
            'designs' => $designsArray

       ));
    }
}
