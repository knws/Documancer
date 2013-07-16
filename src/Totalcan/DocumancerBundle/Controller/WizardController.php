<?php

namespace Totalcan\DocumancerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Totalcan\DocumancerBundle\Model\Wizard;
use Totalcan\DocumancerBundle\Entity\Client;
use Totalcan\DocumancerBundle\Entity\Design;
use Totalcan\DocumancerBundle\Entity\Template;

use Totalcan\DocumancerBundle\Form\ClientType;

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

        $em = $this->getDoctrine()->getManager();

        $clients = $em->getRepository('TotalcanDocumancerBundle:Client')->findByUserId(1);

        $client = new Client();
        $form = $this->createForm($this->get('form.type.client'), $client);

        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {

            $form->handleRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($client);
                $em->flush();

                return $this->redirect($this->generateUrl('wizard_client_id', array('id' => $client->getId())));
            }
        }

        $step = Wizard::getStep($this->get('session'));

        $engine = $this->container->get('templating');
        $clientForm = $engine->render('TotalcanDocumancerBundle:Wizard:clientForm.html.twig', array( 'form' => $form->createView()));

        return $this->render('TotalcanDocumancerBundle:Wizard:client.html.twig', array(
            'clientForm' => $clientForm,
            'clients' => $clients,
       ));
    }

    public function clientIdAction($id)
    {
        $this->get('session')->set('clientId', $id);

        $em = $this->getDoctrine()->getManager();

        $client = new Client();
        $form = $this->createForm($this->get('form.type.client'), $client);

        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {

            $form->handleRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($client);
                $em->flush();

                return $this->redirect($this->generateUrl('wizard_client_id', array('id' => $client->getId())));
            }
        }
        
        $step = Wizard::getStep($this->get('session'));

        $clients = $em->getRepository('TotalcanDocumancerBundle:Client')->find($id);
        $form = $this->createForm($this->get('form.type.client'), $clients);

        $engine = $this->container->get('templating');
        $clientForm = $engine->render('TotalcanDocumancerBundle:Wizard:clientForm.html.twig', array( 'form' => $form->createView(), 'clients' => $clients));

        return $this->render('TotalcanDocumancerBundle:Wizard:client.html.twig', array(
            'clientForm' => $clientForm,
            'clients' => $clients,
       ));
    }

    public function designAction()
    {

    }

    public function designIdAction($id)
    {

    }

    public function templateAction()
    {

    }

    public function templateIdAction($id)
    {

    }

}
