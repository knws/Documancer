<?php

namespace Totalcan\DocumancerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Totalcan\DocumancerBundle\Entity\User;

use Totalcan\DocumancerBundle\Form\UserType;

class UserController extends Controller
{

    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('TotalcanDocumancerBundle:User')->getUsersList();

        if (true === $this->get('security.context')->isGranted('ROLE_SUPER_ADMIN')) {
            $userLists = $em->getRepository('TotalcanDocumancerBundle:User')->findAll();
        }

        return $this->render('TotalcanDocumancerBundle:User:list.html.twig', array(
            'userLists' => $userLists,
            'users' => $users
       ));
    }

    public function newAction()
    {
        $userList = new User();
        //$form = $this->createForm(new UserType(), $userList);
        $form = $this->createForm($this->get('form.type.user'), $userList);

        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('TotalcanDocumancerBundle:User')->getUsersList();

        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {

                $em = $this->getDoctrine()
                           ->getEntityManager();
                $em->persist($userList);
                $em->flush();

                return $this->redirect($this->generateUrl('user_list'));
            }
        }

        return $this->render('TotalcanDocumancerBundle:User:new.html.twig', array(
            'form' => $form->createView(),
            'users' => $users
       ));
    }

    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $userList = $em->getRepository('TotalcanDocumancerBundle:User')->find($id);
        $users = $em->getRepository('TotalcanDocumancerBundle:User')->getUsersList();
        //$form = $this->createForm(new UserType(), $userList);
        $form = $this->createForm($this->get('form.type.user'), $userList);
        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {

                $em = $this->getDoctrine()
                           ->getEntityManager();
                $em->persist($userList);
                $em->flush();

                return $this->redirect($this->generateUrl('user_list'));
            }
        }

        return $this->render('TotalcanDocumancerBundle:User:edit.html.twig', array(
            'form' => $form->createView(),
            'users' => $users,
            'userList' => $userList,
       ));
    }

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $userList = $em->getRepository('TotalcanDocumancerBundle:User')->find($id);

        if (!$userList) {
            throw $this->createNotFoundException('No userList found for id '.$id);
        }

        $em->remove($userList);
        $em->flush();

        return $this->redirect($this->generateUrl('user_list'));
    }
}
