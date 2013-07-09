<?php

namespace Totalcan\DocumancerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

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
}

