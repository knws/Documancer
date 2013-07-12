<?php

namespace Totalcan\DocumancerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Totalcan\DocumancerBundle\Entity\Design;
use Totalcan\DocumancerBundle\Entity\User;

use Totalcan\DocumancerBundle\Form\DesignType;
use Totalcan\DocumancerBundle\Form\UserType;

class DesignController extends Controller
{
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('TotalcanDocumancerBundle:User')->getUsersList();

        if (true === $this->get('security.context')->isGranted('ROLE_SUPER_ADMIN')) {
            $designs = $em->getRepository('TotalcanDocumancerBundle:Design')->findAll();


        } else {
            $usr= $this->get('security.context')->getToken()->getUser();
            $designs = $em->getRepository('TotalcanDocumancerBundle:Design')->findByUserId($usr->getId());
        }

        for($i=0; $i<=sizeof($designs)-1; $i++) {
            $designsArray[] = array(
                'id' => $designs[$i]->getId(),
                'variables' => $designs[$i]->getVariables(),
                'design' => $designs[$i]->getDesign(),
                'date' => $designs[$i]->getDate(),
                'userId' => $designs[$i]->getUserId()->getVariables(),
                'title' => $designs[$i]->getTitle()
            );
        }

        return $this->render('TotalcanDocumancerBundle:Design:list.html.twig', array(
            'designs' => $designsArray,
            'users' => $users
       ));
    }

    public function newAction()
    {
        $design = new Design();
        //$form = $this->createForm(new DesignType(), $design);
        $form = $this->createForm($this->get('form.type.design'), $design);

        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('TotalcanDocumancerBundle:User')->getUsersList();

        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {

                $em = $this->getDoctrine()
                           ->getEntityManager();
                $em->persist($design);
                $em->flush();

                return $this->redirect($this->generateUrl('design_list'));
            }
        }

        return $this->render('TotalcanDocumancerBundle:Design:new.html.twig', array(
            'form' => $form->createView(),
            'users' => $users
       ));
    }

    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $design = $em->getRepository('TotalcanDocumancerBundle:Design')->find($id);
        $users = $em->getRepository('TotalcanDocumancerBundle:User')->getUsersList();
        //$form = $this->createForm(new DesignType(), $design);
        $form = $this->createForm($this->get('form.type.design'), $design);
        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {

                $em = $this->getDoctrine()
                           ->getEntityManager();
                $em->persist($design);
                $em->flush();

                return $this->redirect($this->generateUrl('design_list'));
            }
        }

        return $this->render('TotalcanDocumancerBundle:Design:edit.html.twig', array(
            'form' => $form->createView(),
            'users' => $users,
            'design' => $design,
       ));
    }

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $design = $em->getRepository('TotalcanDocumancerBundle:Design')->find($id);

        if (!$design) {
            throw $this->createNotFoundException('No design found for id '.$id);
        }

        $em->remove($design);
        $em->flush();

        return $this->redirect($this->generateUrl('design_list'));
    }

    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $design = $em->getRepository('TotalcanDocumancerBundle:Design')->find($id);

        $doc = array(
            'id' => $designs[$i]->getId(),
            'variables' => $designs[$i]->getVariables(),
            'design' => $designs[$i]->getDesign(),
            'date' => $designs[$i]->getDate(),
            'userId' => $designs[$i]->getUserId()->getVariables(),
            'title' => $designs[$i]->getTitle()
        );

        foreach (json_decode($design->getVariables(), 1) as $key => $val) {
            $data[$key] = $val;
        }

        $env = new \Twig_Environment(new \Twig_Loader_String());
        $html = $env->render( $doc['template'], $data);
        return new Response($html);
    }
}
