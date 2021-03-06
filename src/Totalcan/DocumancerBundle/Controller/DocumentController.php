<?php

namespace Totalcan\DocumancerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use Totalcan\DocumancerBundle\Entity\Document;
use Totalcan\DocumancerBundle\Entity\Template;
use Totalcan\DocumancerBundle\Entity\Client;
use Totalcan\DocumancerBundle\Entity\Design;
use Totalcan\DocumancerBundle\Entity\User;

use Totalcan\DocumancerBundle\Form\DocumentType;
use Totalcan\DocumancerBundle\Form\TemplateType;
use Totalcan\DocumancerBundle\Form\ClientType;
use Totalcan\DocumancerBundle\Form\DesignType;
use Totalcan\DocumancerBundle\Form\UserType;

class DocumentController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('TotalcanDocumancerBundle:Document:index.html.twig', array('name' => $name, 'title' => $name) );
    }

    public function imageAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $document = $em->getRepository('TotalcanDocumancerBundle:Document')->find($id);

        $data = array(
            'id' => $document->getId(),
            'variables' => json_decode($document->getVariables(), 1),
            'template' => $document->getTemplate(),
        );

        $env = new \Twig_Environment(new \Twig_Loader_String());
        $html = $env->render( $data['template'], $data);

        return new Response(
            $this->get('knp_snappy.image')->getOutputFromHtml(
                    //iconv("UTF-8", "windows-1251", $html)
                    $html
                    ),
            200,
            array(
                'Content-Type'          => 'image/jpg',
                'Content-Disposition'   => 'filename="image.jpg"'
            )
        );
    }

    public function pdfAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $document = $em->getRepository('TotalcanDocumancerBundle:Document')->find($id);

        $doc = array(
            'id' => $document->getId(),
            'variables' => json_decode($document->getVariables(), 1),
            'template' => $document->getTemplate(),
            'date' => $document->getDate(),
            'userId' => $document->getUserId()->getVariables(),
            'designId' => $document->getDesignId()->getTitle(),
            'templateId' => $document->getTemplateId()->getTitle(),
            'clientId' => $document->getClientId()->getVariables(),
            'title' => $document->getTitle()
        );

        foreach (json_decode($document->getVariables(), 1) as $key => $val) {
            $data[$key] = $val;
        }

        $env = new \Twig_Environment(new \Twig_Loader_String());
        $html = $env->render( $doc['template'], $data);
        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml(
                    //iconv("UTF-8", "windows-1251", $html)
                    $html
                    ),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'attachment; filename="'.$doc['title'].'.pdf"'
            )
        );

//        return new Response(
//            $this->get('knp_snappy.pdf')->getOutput('http://google.com'),
//            200,
//            array(
//                'Content-Type'          => 'application/pdf',
//                'Content-Disposition'   => 'attachment; filename="file.pdf"'
//            )
//        );
    }

    public function urlAction($name)
    {
//        $pageUrl = $this->generateUrl('homepage', array('name' => $name), true);

        return new Response(
            $this->get('knp_snappy.pdf')->getOutput('http://google.com'),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'attachment; filename="file.pdf"'
            )
        );
    }

    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('TotalcanDocumancerBundle:User')->getUsersList();

        if (true === $this->get('security.context')->isGranted('ROLE_SUPER_ADMIN')) {
            $documents = $em->getRepository('TotalcanDocumancerBundle:Document')->findAll();


        } else {
            $usr= $this->get('security.context')->getToken()->getUser();
            $documents = $em->getRepository('TotalcanDocumancerBundle:Document')->findByUserId($usr->getId());
        }

        return $this->render('TotalcanDocumancerBundle:Document:list.html.twig', array(
            'documents' => $documents,
            'users' => $users
       ));
    }

    public function newAction()
    {
        $document = new Document();
        //$form = $this->createForm(new DocumentType(), $document);
        $form = $this->createForm($this->get('form.type.document'), $document);

        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('TotalcanDocumancerBundle:User')->getUsersList();

        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {

                $em = $this->getDoctrine()
                           ->getEntityManager();
                $em->persist($document);
                $em->flush();

                return $this->redirect($this->generateUrl('document_list'));
            }
        }

        return $this->render('TotalcanDocumancerBundle:Document:new.html.twig', array(
            'form' => $form->createView(),
            'users' => $users
       ));
    }

    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $document = $em->getRepository('TotalcanDocumancerBundle:Document')->find($id);
        $users = $em->getRepository('TotalcanDocumancerBundle:User')->getUsersList();
        //$form = $this->createForm(new DocumentType(), $document);
        $form = $this->createForm($this->get('form.type.document'), $document);
        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {

                $em = $this->getDoctrine()
                           ->getEntityManager();
                $em->persist($document);
                $em->flush();

                return $this->redirect($this->generateUrl('document_list'));
            }
        }

        return $this->render('TotalcanDocumancerBundle:Document:edit.html.twig', array(
            'form' => $form->createView(),
            'users' => $users,
            'document' => $document,
       ));
    }

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $document = $em->getRepository('TotalcanDocumancerBundle:Document')->find($id);

        if (!$document) {
            throw $this->createNotFoundException('No document found for id '.$id);
        }

        $em->remove($document);
        $em->flush();

        return $this->redirect($this->generateUrl('document_list'));
    }

    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $document = $em->getRepository('TotalcanDocumancerBundle:Document')->find($id);

        $doc = array(
            'id' => $document->getId(),
            'variables' => json_decode($document->getVariables(), 1),
            'template' => $document->getTemplate(),
            'date' => $document->getDate(),
            'userId' => $document->getUserId()->getVariables(),
            'designId' => $document->getDesignId()->getTitle(),
            'templateId' => $document->getTemplateId()->getTitle(),
            'clientId' => $document->getClientId()->getVariables(),
            'title' => $document->getTitle()
        );

        foreach (json_decode($document->getVariables(), 1) as $key => $val) {
            $data[$key] = $val;
        }

        $env = new \Twig_Environment(new \Twig_Loader_String());
        $html = $env->render( $doc['template'], $data);
        return new Response($html);
    }
}

