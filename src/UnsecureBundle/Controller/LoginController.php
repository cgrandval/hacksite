<?php

namespace UnsecureBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use UnsecureBundle\Form\Model\Login;
use UnsecureBundle\Form\Type\LoginType;

class LoginController extends Controller
{
    public function indexAction(Request $request)
    {
        $loginService = $this->get('unsecure.login');
        $sessionService = $this->get('unsecure.session');
        
        // Redirect if already logged
        if (-1 !== $sessionService->getData()->userId) {
            return $this->redirect($this->generateUrl('unsecure_homepage'));
        }
        
        $login = new Login();
        $loginForm = $this->createForm(new LoginType(), $login);

        $loginForm->handleRequest($request);
        
        if ($loginForm->isValid()) {
            
            $user = $loginService->login($login->getLogin(), $login->getPwd());
            
            $sessionData = $sessionService->getData();
            
            $sessionData->userId = $user->getId();
            
            $sessionService->setData($sessionData);
            
            return $this->redirect($this->generateUrl('unsecure_homepage'));
        }

        return $this->render('UnsecureBundle:Login:index.html.twig', array(
            'loginForm' => $loginForm->createView(),
        ));
    }
    
    public function logoutAction()
    {
        $sessionService = $this->get('unsecure.session');
        
        // Redirect if not logged
        if (-1 === $sessionService->getData()->userId) {
            return $this->redirect($this->generateUrl('unsecure_homepage'));
        }
        
        $sessionService->logout();
        
        return $this->redirect($this->generateUrl('unsecure_homepage'));
    }
}
