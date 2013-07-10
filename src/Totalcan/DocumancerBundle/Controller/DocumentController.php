<?php

namespace Totalcan\DocumancerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use Totalcan\DocumancerBundle\Entity\Document;
use Totalcan\DocumancerBundle\Entity\Template;
use Totalcan\DocumancerBundle\Entity\Client;
use Totalcan\DocumancerBundle\Entity\Design;
use Totalcan\DocumancerBundle\Entity\User;

use Totalcan\DocumancerBundle\Entity\DocumentType;
use Totalcan\DocumancerBundle\Entity\TemplateType;
use Totalcan\DocumancerBundle\Entity\ClientType;
use Totalcan\DocumancerBundle\Entity\DesignType;
use Totalcan\DocumancerBundle\Entity\UserType;

class DocumentController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('TotalcanDocumancerBundle:Document:index.html.twig', array('name' => $name, 'title' => $name) );
    }

    public function imageAction($name)
    {
        $html = $this->renderView('TotalcanDocumancerBundle:Document:index.html.twig', array(
            'name'  => $name,
            'title' => $name
        ));

        return new Response(
            $this->get('knp_snappy.image')->getOutputFromHtml($html),
            200,
            array(
                'Content-Type'          => 'image/jpg',
                'Content-Disposition'   => 'filename="image.jpg"'
            )
        );
    }

    public function templateAction($name)
    {
        $html = $this->renderView('TotalcanDocumancerBundle:Document:index.html.twig', array(
            'name'  => $name,
            'title' => $name
        ));

        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'attachment; filename="file.pdf"'
            )
        );
    }

    public function urlAction($name)
    {
        $pageUrl = $this->generateUrl('totalcan_documancer_homepage', array('name' => $name), true);

        return new Response(
            $this->get('knp_snappy.pdf')->getOutput($pageUrl),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'attachment; filename="file.pdf"'
            )
        );
    }

    public function entityAction()
    {
        $user = new User();
        $user->setVariables('Test user');
        $user->setDate(new \DateTime());

        $client = new Client();
        $client->setVariables('Test client');
        $client->setDate(new \DateTime());
        $client->setUserId($user);

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->persist($client);
        $em->flush();

        return new Response(
            'Created user id: '.$user->getId().' and client id: '.$client->getId()
        );
    }

    public function newAction($_route)
    {
//        $user = new User();
//        $form = $this->createForm(new UserType(), $user);
//
//        $request = $this->getRequest();
//        if ($request->getMethod() == 'POST') {
//            $form->handleRequest($request);
//
//            if ($form->isValid()) {
//
//                $em = $this->getDoctrine()
//                           ->getEntityManager();
//                $em->persist($user);
//                $em->flush();
//
//                return $this->redirect($this->generateUrl('totalcan_documancer_new_user'));
//            }
//        }
//
//        return $this->render('TotalcanDocumancerBundle:Document:new.html.twig', array(
//            'form' => $form->createView()
//       ));
        $user = new Client();
        $form = $this->createForm(new ClientType(), $user);

        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {

                $em = $this->getDoctrine()
                           ->getEntityManager();
                $em->persist($user);
                $em->flush();

                return $this->redirect($this->generateUrl('totalcan_documancer_new_user'));
            }
        }

        return $this->render('TotalcanDocumancerBundle:Document:new.html.twig', array(
            'form' => $form->createView()
       ));
    }
}

