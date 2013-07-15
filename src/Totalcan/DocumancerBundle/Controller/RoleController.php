<?php

namespace Totalcan\DocumancerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use Totalcan\DocumancerBundle\Entity\Role;
use Totalcan\DocumancerBundle\Entity\Template;
use Totalcan\DocumancerBundle\Entity\Client;
use Totalcan\DocumancerBundle\Entity\Design;
use Totalcan\DocumancerBundle\Entity\User;

use Totalcan\DocumancerBundle\Form\RoleType;
use Totalcan\DocumancerBundle\Form\TemplateType;
use Totalcan\DocumancerBundle\Form\ClientType;
use Totalcan\DocumancerBundle\Form\DesignType;
use Totalcan\DocumancerBundle\Form\UserType;

class RoleController extends Controller
{
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('TotalcanDocumancerBundle:User')->getUsersList();

        if (true === $this->get('security.context')->isGranted('ROLE_SUPER_ADMIN')) {
            $roles = $em->getRepository('TotalcanDocumancerBundle:Role')->findAll();


        } else {
            $usr= $this->get('security.context')->getToken()->getUser();
            $roles = $em->getRepository('TotalcanDocumancerBundle:Role')->findByUserId($usr->getId());
        }

        for($i=0; $i<=sizeof($roles)-1; $i++) {
            $rolesArray[] = array(
                'id' => $roles[$i]->getId(),
                'name' => $roles[$i]->getName(),
                'role' => $roles[$i]->getRole()
            );
        }

        return $this->render('TotalcanDocumancerBundle:Role:list.html.twig', array(
            'roles' => $rolesArray,
            'users' => $users
       ));
    }

    public function newAction()
    {
        $role = new Role();
        //$form = $this->createForm(new RoleType(), $role);
        $form = $this->createForm($this->get('form.type.role'), $role);

        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('TotalcanDocumancerBundle:User')->getUsersList();

        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {

                $em = $this->getDoctrine()
                           ->getEntityManager();
                $em->persist($role);
                $em->flush();

                return $this->redirect($this->generateUrl('role_list'));
            }
        }

        return $this->render('TotalcanDocumancerBundle:Role:new.html.twig', array(
            'form' => $form->createView(),
            'users' => $users
       ));
    }

    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $role = $em->getRepository('TotalcanDocumancerBundle:Role')->find($id);
        $users = $em->getRepository('TotalcanDocumancerBundle:User')->getUsersList();
        //$form = $this->createForm(new RoleType(), $role);
        $form = $this->createForm($this->get('form.type.role'), $role);
        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {

                $em = $this->getDoctrine()
                           ->getEntityManager();
                $em->persist($role);
                $em->flush();

                return $this->redirect($this->generateUrl('role_list'));
            }
        }

        return $this->render('TotalcanDocumancerBundle:Role:edit.html.twig', array(
            'form' => $form->createView(),
            'users' => $users,
            'role' => $role,
       ));
    }

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $role = $em->getRepository('TotalcanDocumancerBundle:Role')->find($id);

        if (!$role) {
            throw $this->createNotFoundException('No role found for id '.$id);
        }

        $em->remove($role);
        $em->flush();

        return $this->redirect($this->generateUrl('role_list'));
    }
}

