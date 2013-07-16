<?php

namespace Totalcan\DocumancerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class WizardController extends Controller
{
    public function wizardAction()
    {
        return $this->render('TotalcanDocumancerBundle:Wizard:wizard.html.twig', array(

       ));
    }

    public function clientAction()
    {
        return $this->render('TotalcanDocumancerBundle:Wizard:client.html.twig', array(

       ));
    }

    public function clientIdAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('TotalcanDocumancerBundle:User')->getUsersList();

        $usr= $this->get('security.context')->getToken()->getUser();
        //$clients = $em->getRepository('TotalcanDocumancerBundle:Client')->findByUserIdAndClientId($usr->getId(), $id);
        $clients = $em->getRepository('TotalcanDocumancerBundle:Client')->find($id);
        $designs = $em->getRepository('TotalcanDocumancerBundle:Design')->findByUserId(1);
        $form = $this->createForm($this->get('form.type.client'), $clients);

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

    public function designAction()
    {
        return $this->render('TotalcanDocumancerBundle:Wizard:design.html.twig', array(

       ));
    }

    public function designIdAction($id)
    {
        return $this->render('TotalcanDocumancerBundle:Wizard:design.html.twig', array(

       ));
    }

    public function templateAction()
    {
        return $this->render('TotalcanDocumancerBundle:Wizard:template.html.twig', array(

       ));
    }

    public function templateIdAction($id)
    {
        return $this->render('TotalcanDocumancerBundle:Wizard:template.html.twig', array(

       ));
    }

}
