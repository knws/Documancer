<?php

namespace Totalcan\DocumancerBundle\Controller;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Totalcan\DocumancerBundle\Model\Wizard;

class WizardController extends Controller
{
    public function wizardAction()
    {
        $this->get('session')->set('templateId', '0');
        $this->get('session')->set('designId', '0');
        $this->get('session')->set('clientId', '0');
        $step = Wizard::getStep($this->get('session'));

        return $this->render('TotalcanDocumancerBundle:Wizard:wizard.html.twig', array(

       ));
    }

    public function clientAction()
    {
        $this->get('session')->set('clientId', '0');
        return $this->render('TotalcanDocumancerBundle:Wizard:client.html.twig', array(

       ));
    }

    public function clientIdAction($id)
    {
        $this->get('session')->set('clientId', $id);

        $step = Wizard::getStep($this->get('session'));
        $em = $this->getDoctrine()->getManager();
        $clients = $em->getRepository('TotalcanDocumancerBundle:Client')->find($id);
        $form = $this->createForm($this->get('form.type.client'), $clients);

        $engine = $this->container->get('templating');
        $clientForm = $engine->render('TotalcanDocumancerBundle:Wizard:clientForm.html.twig', array( 'form' => $form->createView()));

        return $this->render('TotalcanDocumancerBundle:Wizard:client.html.twig', array(
            'clientForm' => $clientForm,

            'clients' => $clients,
       ));
    }

    public function designAction()
    {
        $em = $this->getDoctrine()->getManager();

//        $clients    = $em->getRepository('TotalcanDocumancerBundle:Client')->find($id);
        $designs    = $em->getRepository('TotalcanDocumancerBundle:Design')->findByUserId(1);
//        $templates  = $em->getRepository('TotalcanDocumancerBundle:Template')->findByUserId(1);

//        $form = $this->createForm($this->get('form.type.client'), $clients);

//        $engine = $this->container->get('templating');
//        $clientForm = $engine->render('TotalcanDocumancerBundle:Wizard:clientForm.html.twig', array( 'form' => $form->createView()));

        return $this->render('TotalcanDocumancerBundle:Wizard:design.html.twig', array(
//            'clientForm' => $clientForm,
//
//            'client' => $clients,
            'designs' => $designs,
//            'templates' => $templates,
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
