<?php

namespace Totalcan\DocumancerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;

use Totalcan\DocumancerBundle\Entity\User;
use Totalcan\DocumancerBundle\Entity\Role;

class AdminController extends Controller
{
    public function loginAction(Request $request)
    {
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $request->getSession()->get(SecurityContext::AUTHENTICATION_ERROR);
        }

        return $this->render('TotalcanDocumancerBundle:Frontpage:index.html.twig', array(
            'last_username' => $request->getSession()->get(SecurityContext::LAST_USERNAME),
            'error'         => $error,
        ));
    }

    public function logoutAction()
    {
    }

    function securityCheckAction()
    {

    }

    public function indexAction()
    {
        return $this->render('TotalcanDocumancerBundle:Admin:index.html.twig');
    }

    public function securedAction()
    {
        return $this->render('TotalcanDocumancerBundle:Admin:index.html.twig');
    }

    public function superLogOutAction()
    {
        $_SESSION['userId'] = 0;
        return $this->redirect($this->generateUrl('logout'));
    }

    public function superAuthAction()
    {
        $request =  $this->get('request');

        $sign = array();
        $sign['hash_salt'] = "as34tfvFs1lI";
        $sign['timehash'] = round( time() / 1000 ) * 1000;
        $sign['user_id'] = intval( $request->query->get('user_id'));
        $sign['token'] = $request->query->get('token');
        $sign['host'] = $_SERVER['HTTP_HOST'];
        $token = md5( $sign['hash_salt'] . $sign['timehash'] . $sign['user_id'] . $sign['token'] . $sign['host'] );
        $sign['url'] = "http://bravoreg.com/?act=getUser&token={$token}&user_id={$sign['user_id']}&host={$sign['host']}";
        $result = json_decode( file_get_contents( $sign['url'] ) );
        unset( $sign );
        $return = array();
        if( isset( $result->user ) && $result->user )
        {

            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository('TotalcanDocumancerBundle:User')->loadUserByUsername2($request->query->get('user_id'));
            $role = $em->getRepository('TotalcanDocumancerBundle:Role')->find(4);

            if($user!=null) {
                $user->setPassword($token);
                $user->setUsername($result->user->officialName);
                $user->setEmail($result->user->email);
                $user->setExId($request->query->get('user_id'));
                $user->addRole($role);
                $em->persist($user);
                $em->flush();
            } else {
                $user = new User();
                $user->setUsername($result->user->officialName);
                $user->setPassword($token);
                $user->setEmail($result->user->email);
                $user->setExId($request->query->get('user_id'));
                $user->addRole($role);
                $em->persist($user);
                $em->flush();
            }

            return $this->redirect($this->generateUrl('security_check', array(
                '_username'  => $result->user->officialName,
                '_password' => $token,
            )));
        }
    }
}
