<?php

namespace Totalcan\DocumancerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Totalcan\DocumancerBundle\Entity\Template;
use Totalcan\DocumancerBundle\Entity\User;

use Totalcan\DocumancerBundle\Form\TemplateType;
use Totalcan\DocumancerBundle\Form\UserType;

class TemplateController extends Controller
{
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('TotalcanDocumancerBundle:User')->getUsersList();

        if (true === $this->get('security.context')->isGranted('ROLE_SUPER_ADMIN')) {
            $templates = $em->getRepository('TotalcanDocumancerBundle:Template')->findAll();


        } else {
            $usr= $this->get('security.context')->getToken()->getUser();
            $templates = $em->getRepository('TotalcanDocumancerBundle:Template')->findByUserId($usr->getId());
        }

        return $this->render('TotalcanDocumancerBundle:Template:list.html.twig', array(
            'templates' => $templates,
            'users' => $users
       ));
    }

    public function newAction()
    {
        $template = new Template();
        //$form = $this->createForm(new TemplateType(), $template);
        $form = $this->createForm($this->get('form.type.template'), $template);

        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('TotalcanDocumancerBundle:User')->getUsersList();

        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {

                $em = $this->getDoctrine()
                           ->getEntityManager();
                $em->persist($template);
                $em->flush();

                return $this->redirect($this->generateUrl('template_list'));
            }
        }

        return $this->render('TotalcanDocumancerBundle:Template:new.html.twig', array(
            'form' => $form->createView(),
            'users' => $users
       ));
    }

    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $template = $em->getRepository('TotalcanDocumancerBundle:Template')->find($id);
        $users = $em->getRepository('TotalcanDocumancerBundle:User')->getUsersList();
        $form = $this->createForm($this->get('form.type.template'), $template);
        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {

                $em = $this->getDoctrine()
                           ->getEntityManager();
                $em->persist($template);
                $em->flush();

                return $this->redirect($this->generateUrl('template_list'));
            }
        }

        return $this->render('TotalcanDocumancerBundle:Template:edit.html.twig', array(
            'form' => $form->createView(),
            'users' => $users,
            'template' => $template,
       ));
    }

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $template = $em->getRepository('TotalcanDocumancerBundle:Template')->find($id);

        if (!$template) {
            throw $this->createNotFoundException('No template found for id '.$id);
        }

        $em->remove($template);
        $em->flush();

        return $this->redirect($this->generateUrl('template_list'));
    }

    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $template = $em->getRepository('TotalcanDocumancerBundle:Template')->find($id);

        $doc = array(
            'id' => $templates[$i]->getId(),
            'variables' => $templates[$i]->getVariables(),
            'template' => $templates[$i]->getTemplate(),
            'date' => $templates[$i]->getDate(),
            'userId' => $templates[$i]->getUserId()->getVariables(),
            'title' => $templates[$i]->getTitle()
        );

        foreach (json_decode($template->getVariables(), 1) as $key => $val) {
            $data[$key] = $val;
        }

        $env = new \Twig_Environment(new \Twig_Loader_String());
        $html = $env->render( $doc['template'], $data);
        return new Response($html);
    }
}
