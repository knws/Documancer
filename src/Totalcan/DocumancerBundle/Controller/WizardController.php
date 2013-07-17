<?php

namespace Totalcan\DocumancerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use Totalcan\DocumancerBundle\Model\Wizard;
use Totalcan\DocumancerBundle\Entity\Client;
use Totalcan\DocumancerBundle\Entity\Document;
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

    public function previewAction()
    {
        $session = $this->get('session');
        $em = $this->getDoctrine()->getManager();
        $design1 = $em->getRepository('TotalcanDocumancerBundle:Design')->find($session->get('designId'));
        $client1 = $em->getRepository('TotalcanDocumancerBundle:Client')->find($session->get('clientId'));
        $template1 = $em->getRepository('TotalcanDocumancerBundle:Template')->find($session->get('templateId'));

        $design = $design1->getDesign();
        $template = $template1->getTemplate();

        $data = array();
        $var = json_decode($template1->getVariables(), 1);
        foreach ( $var as $key => $val) {
            $data[$key] = $val;
        }

        foreach (json_decode($client1->getVariables(), 1) as $key => $val) {
            $data[$key] = $val;
        }

        $env = new \Twig_Environment(new \Twig_Loader_String());
        $data['TEMPLATE'] = $env->render( $template, $data);

        foreach (json_decode($design1->getVariables(), 1) as $key => $val) {
            $data[$key] = $val;
        }

        $html = $env->render( $design, $data);

        return new Response($html);
    }

    public function saveAction()
    {
        $session = $this->get('session');
        $em = $this->getDoctrine()->getManager();

        $design1 = $em->getRepository('TotalcanDocumancerBundle:Design')->find($session->get('designId'));
        $client1 = $em->getRepository('TotalcanDocumancerBundle:Client')->find($session->get('clientId'));
        $template1 = $em->getRepository('TotalcanDocumancerBundle:Template')->find($session->get('templateId'));

        $design = $design1->getDesign();
        $template = $template1->getTemplate();

        $data = array();
        $var = json_decode($template1->getVariables(), 1);
        foreach ( $var as $key => $val) {
            $data[$key] = $val;
        }

        foreach (json_decode($client1->getVariables(), 1) as $key => $val) {
            $data[$key] = $val;
        }

        $env = new \Twig_Environment(new \Twig_Loader_String());
        $data['TEMPLATE'] = $env->render( $template, $data);

        foreach (json_decode($design1->getVariables(), 1) as $key => $val) {
            $data[$key] = $val;
        }

        $document = new Document();
        $document->setVariables(json_encode($data));
        $document->setTemplateId($template1);
        $document->setClientId($client1);
        $document->setDesignId($design1);
        $document->setTemplate($design);
        $document->setTitle('test save');

        $em->persist($document);
        $em->flush();
        return $this->redirect($this->generateUrl('document_list'));
    }

    public function clientAction($ajax)
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

        $sel = ($ajax == 'ajax') ? 'Selector' : '';

        return $this->render('TotalcanDocumancerBundle:Wizard:client'.$sel.'.html.twig', array(
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


    public function designAction($ajax)
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

        $sel = ($ajax == 'ajax') ? 'Selector' : '';

        return $this->render('TotalcanDocumancerBundle:Wizard:design'.$sel.'.html.twig', array(
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

    public function templateAction($ajax)
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

        $sel = ($ajax == 'ajax') ? 'Selector' : '';

        return $this->render('TotalcanDocumancerBundle:Wizard:template'.$sel.'.html.twig', array(
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
