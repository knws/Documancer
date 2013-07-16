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
//        $this->get('session')->set('templateId', '0');
//        $this->get('session')->set('designId', '0');
//        $this->get('session')->set('clientId', '0');
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

        $engine = $this->container->get('templating');
        $clientForm = $engine->render('TotalcanDocumancerBundle:Wizard:clientForm.html.twig', array( 'form' => $form->createView()));

        return $this->render('TotalcanDocumancerBundle:Wizard:clientSelector.html.twig', array(
            'clientForm' => $clientForm,
            'clients' => $clients,
       ));
    }

    public function clientIdAction($id, $ajax)
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

        $clients = $em->getRepository('TotalcanDocumancerBundle:Client')->find($id);
        $form = $this->createForm($this->get('form.type.client'), $clients);

        $engine = $this->container->get('templating');
        $clientForm = $engine->render('TotalcanDocumancerBundle:Wizard:clientForm.html.twig', array( 'form' => $form->createView(), 'clients' => $clients));

        $sel = ($ajax == 'ajax') ? 'Selector' : '';

        return $this->render('TotalcanDocumancerBundle:Wizard:client'.$sel.'.html.twig', array(
                'clientForm' => $clientForm,
                'clients' => $clients,
            ));
    }


    public function designAction()
    {
        $this->get('session')->set('designId', '0');

        $em = $this->getDoctrine()->getManager();

        $designs = $em->getRepository('TotalcanDocumancerBundle:Design')->findByUserId(1);

        $design = new Design();
        $form = $this->createForm($this->get('form.type.design'), $design);

        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {

            $form->handleRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($design);
                $em->flush();

                return $this->redirect($this->generateUrl('wizard_design_id', array('id' => $design->getId())));
            }
        }

        $engine = $this->container->get('templating');
        $designForm = $engine->render('TotalcanDocumancerBundle:Wizard:designForm.html.twig', array( 'form' => $form->createView()));

        return $this->render('TotalcanDocumancerBundle:Wizard:designSelector.html.twig', array(
            'designForm' => $designForm,
            'designs' => $designs,
       ));
    }

    public function designIdAction($id, $ajax)
    {
        $this->get('session')->set('designId', $id);

        $em = $this->getDoctrine()->getManager();

        $design = new Design();
        $form = $this->createForm($this->get('form.type.design'), $design);

        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {

            $form->handleRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($design);
                $em->flush();

                return $this->redirect($this->generateUrl('wizard_design_id', array('id' => $design->getId())));
            }
        }

        $designs = $em->getRepository('TotalcanDocumancerBundle:Design')->find($id);
        $form = $this->createForm($this->get('form.type.design'), $designs);

        $engine = $this->container->get('templating');
        $designForm = $engine->render('TotalcanDocumancerBundle:Wizard:designForm.html.twig', array( 'form' => $form->createView(), 'designs' => $designs));

        $sel = ($ajax == 'ajax') ? 'Selector' : '';

        return $this->render('TotalcanDocumancerBundle:Wizard:design'.$sel.'.html.twig', array(
            'designForm' => $designForm,
            'designs' => $designs,
       ));
    }

    public function templateAction()
    {
        $this->get('session')->set('templateId', '0');

        $em = $this->getDoctrine()->getManager();

        $templates = $em->getRepository('TotalcanDocumancerBundle:Template')->findByUserId(1);

        $template = new Template();
        $form = $this->createForm($this->get('form.type.template'), $template);

        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {

            $form->handleRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($template);
                $em->flush();

                return $this->redirect($this->generateUrl('wizard_template_id', array('id' => $template->getId())));
            }
        }

        $engine = $this->container->get('templating');
        $templateForm = $engine->render('TotalcanDocumancerBundle:Wizard:templateForm.html.twig', array( 'form' => $form->createView()));

        return $this->render('TotalcanDocumancerBundle:Wizard:templateSelector.html.twig', array(
            'templateForm' => $templateForm,
            'templates' => $templates,
       ));
    }

    public function templateIdAction($id, $ajax)
    {
        $this->get('session')->set('templateId', $id);

        $em = $this->getDoctrine()->getManager();

        $template = new Template();
        $form = $this->createForm($this->get('form.type.template'), $template);

        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {

            $form->handleRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($template);
                $em->flush();

                return $this->redirect($this->generateUrl('wizard_template_id', array('id' => $template->getId())));
            }
        }

        $templates = $em->getRepository('TotalcanDocumancerBundle:Template')->find($id);
        $form = $this->createForm($this->get('form.type.template'), $templates);

        $engine = $this->container->get('templating');
        $templateForm = $engine->render('TotalcanDocumancerBundle:Wizard:templateForm.html.twig', array( 'form' => $form->createView(), 'templates' => $templates));

        $sel = ($ajax == 'ajax') ? 'Selector' : '';

        return $this->render('TotalcanDocumancerBundle:Wizard:template'.$sel.'.html.twig', array(
            'templateForm' => $templateForm,
            'templates' => $templates,
       ));
    }
}
