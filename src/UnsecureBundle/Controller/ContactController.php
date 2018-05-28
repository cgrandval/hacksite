<?php

namespace UnsecureBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use UnsecureBundle\Form\Type\ContactType;

class ContactController extends Controller
{

    public function indexAction(Request $request)
    {
        $contactForm = $this->createForm(new ContactType());
        $contactForm->handleRequest($request);

        if ($contactForm->isSubmitted())
        {
            if ($contactForm->isValid())
            {
                $to = 'bula@bulabula.com';
                $subject = 'Client message';
                $from = $contactForm->getData()['email'];
                $message = $contactForm->getData()['message'];

                $headers = "From: " . $from;

                if (mail($to, $subject, $message, $headers))
                {
                    return $this->redirect($this->generateUrl('unsecure_homepage'));
                }
                else
                {
                    throw new \Exception('send mail fail');
                }
            }
        }

        return $this->render('UnsecureBundle:Contact:index.html.twig', array(
                    'contactForm' => $contactForm->createView()
        ));
    }

}
