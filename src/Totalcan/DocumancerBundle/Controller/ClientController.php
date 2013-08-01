<?php

namespace Totalcan\DocumancerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Totalcan\DocumancerBundle\Entity\Client;
use Totalcan\DocumancerBundle\Entity\User;

use Totalcan\DocumancerBundle\Form\ClientType;
use Totalcan\DocumancerBundle\Form\UserType;

class ClientController extends Controller
{
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('TotalcanDocumancerBundle:User')->getUsersList();

        if (true === $this->get('security.context')->isGranted('ROLE_SUPER_ADMIN')) {
            $clients = $em->getRepository('TotalcanDocumancerBundle:Client')->findAll();


        } else {
            $usr= $this->get('security.context')->getToken()->getUser();
            $clients = $em->getRepository('TotalcanDocumancerBundle:Client')->findByUserId($usr->getId());
        }

        return $this->render('TotalcanDocumancerBundle:Client:list.html.twig', array(
            'clients' => $clients,
            'users' => $users
       ));
    }

    public function newAction()
    {
        $client = new Client();
        $form = $this->createForm($this->get('form.type.client'), $client);

        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('TotalcanDocumancerBundle:User')->getUsersList();

        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {

                $em = $this->getDoctrine()
                           ->getEntityManager();
                $em->persist($client);
                $em->flush();

                return $this->redirect($this->generateUrl('client_list'));
            }
        }

        return $this->render('TotalcanDocumancerBundle:Client:new.html.twig', array(
            'form' => $form->createView(),
            'users' => $users
       ));
    }

    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $client = $em->getRepository('TotalcanDocumancerBundle:Client')->find($id);
        $users = $em->getRepository('TotalcanDocumancerBundle:User')->getUsersList();
        $form = $this->createForm($this->get('form.type.client'), $client);
        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {

                $em = $this->getDoctrine()
                           ->getEntityManager();
                $em->persist($client);
                $em->flush();

                return $this->redirect($this->generateUrl('client_list'));
            }
        }

        return $this->render('TotalcanDocumancerBundle:Client:edit.html.twig', array(
            'form' => $form->createView(),
            'users' => $users,
            'client' => $client,
       ));
    }

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $client = $em->getRepository('TotalcanDocumancerBundle:Client')->find($id);

        if (!$client) {
            throw $this->createNotFoundException('No client found for id '.$id);
        }

        $em->remove($client);
        $em->flush();

        return $this->redirect($this->generateUrl('client_list'));
    }

}
