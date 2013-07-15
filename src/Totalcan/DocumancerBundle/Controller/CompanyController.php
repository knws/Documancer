<?php

namespace Totalcan\DocumancerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Totalcan\DocumancerBundle\Entity\Document;
use Totalcan\DocumancerBundle\Entity\Company;
use Totalcan\DocumancerBundle\Entity\Client;
use Totalcan\DocumancerBundle\Entity\Design;
use Totalcan\DocumancerBundle\Entity\User;

use Totalcan\DocumancerBundle\Form\DocumentType;
use Totalcan\DocumancerBundle\Form\CompanyType;
use Totalcan\DocumancerBundle\Form\TemplateType;
use Totalcan\DocumancerBundle\Form\ClientType;
use Totalcan\DocumancerBundle\Form\DesignType;
use Totalcan\DocumancerBundle\Form\UserType;

class CompanyController extends Controller
{
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('TotalcanDocumancerBundle:User')->getUsersList();

        if (true === $this->get('security.context')->isGranted('ROLE_SUPER_ADMIN')) {
            $company = $em->getRepository('TotalcanDocumancerBundle:Company')->findAll();

        } else {
            $usr= $this->get('security.context')->getToken()->getUser();
            $company = $em->getRepository('TotalcanDocumancerBundle:Company')->findByUserId($usr->getId());
        }

        for($i=0; $i<=sizeof($company)-1; $i++) {
            $companyArray[] = array(
                'id' => $company[$i]->getId(),
                'variables' => json_decode($company[$i]->getVariables(), 1),
                'date' => $company[$i]->getDate(),
                'title' => $company[$i]->getTitle()
            );

            if($company[$i]->getParent()!=null) {
                $companyArray[$i]['parent'] = $company[$i]->getParent()->getTitle();
            } else {
                $companyArray[$i]['parent'] = 'null';
            }
        }

        return $this->render('TotalcanDocumancerBundle:Company:list.html.twig', array(
            'companys' => $companyArray,
            'users' => $users
       ));
    }

    public function newAction()
    {
        $company = new Company();
        //$form = $this->createForm(new CompanyType(), $company);
        $form = $this->createForm($this->get('form.type.company'), $company);

        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('TotalcanDocumancerBundle:User')->getUsersList();

        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {

                $em = $this->getDoctrine()
                           ->getEntityManager();
                $em->persist($company);
                $em->flush();

                return $this->redirect($this->generateUrl('company_list'));
            }
        }

        return $this->render('TotalcanDocumancerBundle:Company:new.html.twig', array(
            'form' => $form->createView(),
            'users' => $users
       ));
    }

    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $company = $em->getRepository('TotalcanDocumancerBundle:Company')->find($id);
        $users = $em->getRepository('TotalcanDocumancerBundle:User')->getUsersList();
        $form = $this->createForm($this->get('form.type.company'), $company);
        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {

                $em = $this->getDoctrine()
                           ->getEntityManager();
                $em->persist($company);
                $em->flush();

                return $this->redirect($this->generateUrl('company_list'));
            }
        }

        return $this->render('TotalcanDocumancerBundle:Company:edit.html.twig', array(
            'form' => $form->createView(),
            'users' => $users,
            'company' => $company,
       ));
    }

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $company = $em->getRepository('TotalcanDocumancerBundle:Company')->find($id);

        if (!$company) {
            throw $this->createNotFoundException('No company found for id '.$id);
        }

        $em->remove($company);
        $em->flush();

        return $this->redirect($this->generateUrl('company_list'));
    }

    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $company = $em->getRepository('TotalcanDocumancerBundle:Company')->find($id);

        $doc = array(
            'id' => $company->getId(),
            'variables' => json_decode($company->getVariables(), 1),
            'date' => $company->getDate(),
            'parent' => $company->getParent(),
            'title' => $company->getTitle()
        );

        foreach (json_decode($company->getVariables(), 1) as $key => $val) {
            $data[$key] = $val;
        }

        $env = new \Twig_Environment(new \Twig_Loader_String());
        $html = $env->render( $doc['template'], $data);
        return new Response($html);
    }
}
