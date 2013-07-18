<?php

namespace Totalcan\DocumancerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;

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

    public function securityCheckAction()
    {
    }

    public function logoutAction()
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

    public function superAuthAction()
    {
//        $session = $this->get('session');
//
//        $sign = array();
//        $sign['hash_salt'] = "as34tfvFs1lI";
//        $sign['timehash'] = round( time() / 1000 ) * 1000;
//        $sign['user_id'] = intval( $_GET['user_id'] );
//        $sign['token'] = $_GET['token'];
//        $sign['host'] = $_SERVER['HTTP_HOST'];
//        $sign['calculate_token'] = md5( $sign['hash_salt'] . $sign['timehash'] . $sign['user_id'] . $sign['token'] . $sign['host'] );
//        $sign['url'] = "http://bravoreg.com/?act=getUser&token={$sign['calculate_token']}&user_id={$sign['user_id']}&host={$sign['host']}";
//        $result = json_decode( file_get_contents( $sign['url'] ) );
//        unset( $sign );
//
//        $return = array();
//        if( isset( $result->user ) && $result->user )
//        {
//                // required: success text
//                $return['msg'] = "Вы вошли как {$result->user->name}";
//                $session->set('_user', $result->user);
//                // TODO
//                /* Проверяем пользователя в бд
//                 *   Если есть, меняем ему пароль
//                 *      Подставляем в запрос $_POST
//                 *      вызываем контроллер логин
//                 *   Если нет, создаем нового
//                 */
//
//
//        }
//        else
//                $return['error'] = "Не удалось войти, попробуйте еще раз.";
//        $request = $this->container->get('request');
//        $request->request->set('_username', 'w3db@yandex.ru');
//        $request->request->set('_password', '123123');
////        return $this->forward('super.controller:loginAction');
//        return $response = $this->forward('TotalcanDocumancerBundle:Admin:login', array(
//        'request'  => $request
//        ));
//        return $this->render('TotalcanDocumancerBundle:Admin:index.html.twig', array('debug' => print_r($request, 1)));

    }
}
