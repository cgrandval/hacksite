<?php

namespace UnsecureBundle\Controller;

use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    public function indexAction()
    {
        $user = $this->get('unsecure.session')->getUser();
        
        if ((null === $user) || !$user->getAdmin()) {
            throw new AccessDeniedHttpException('Vous n\'avez pas access à cette partie.');
        }
        
        $em = $this->getDoctrine()->getManager();
        
        $users = $em->getRepository('UnsecureBundle:User')->findAllWith(true);
        
        return $this->render('UnsecureBundle:Admin:index.html.twig', array(
            'users' => $users,
        ));
    }
}
