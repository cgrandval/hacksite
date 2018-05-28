<?php

namespace UnsecureBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use UnsecureBundle\Form\Type\SubjectType;
use UnsecureBundle\Entity\Subject;
use UnsecureBundle\Entity\Comment;
use UnsecureBundle\Form\Type\CommentType;

class IndexController extends Controller
{

    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $subjects = $em->getRepository('UnsecureBundle:Subject')->recentSubject(10);
    
        return $this->render('UnsecureBundle:Index:index.html.twig', array(
            'subjects' => $subjects
        ));
    }

    public function myNewsAction(Request $request)
    {
        $subjectForm = null;
        $sessionService = $this->get('unsecure.session');

        // Display form create a new subject if already logged
        if (-1 !== $sessionService->getData()->userId)
        {
            $user = $this->get('unsecure.repository.user')->getById($sessionService->getData()->userId);
            $subjectForm = $this->createForm(new SubjectType());
            $subjectForm->handleRequest($request);

            if ($subjectForm->isSubmitted())
            {
                if ($subjectForm->isValid())
                {     
                    $subject = new Subject();
                    $subject->setText($subjectForm->getData()['text']);
                    $subject->setUser($user);
                    $subject->setPrivate($subjectForm->getData()['private']);
                    $subject->setCreationDate(new \DateTime());

                    $em = $this->getDoctrine()->getManager();

                    $em->persist($subject);
                    $em->flush();
                    
                    return $this->redirect($this->generateUrl('unsecure_homepage'));
                }
            }
            $subjectForm = $subjectForm->createView();
        }

        $em = $this->getDoctrine()->getManager();

        $subjects = $em->getRepository('UnsecureBundle:Subject')->mySubjects($sessionService->getData()->userId);

        return $this->render('UnsecureBundle:Index:my-subjects.html.twig', array(
            'subjects' => $subjects, 'subjectForm' => $subjectForm
        ));
    }

    /**
     * @param Request $request
     * @param int $subjectId
     * 
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function subjectAction(Request $request, $subjectId)
    {
        $em = $this->getDoctrine()->getManager();
        $subject = $em->getRepository('UnsecureBundle:Subject')->findFullOne($subjectId);
        $user = $this->get('unsecure.session')->getUser();
        
        if (null === $subject) {
            throw $this->createNotFoundException();
        }
        
        $comment = new Comment();
        $commentForm = $this->createForm(new CommentType(), $comment);
        
        $commentForm->handleRequest($request);
        
        if ((null !== $user) && $commentForm->isValid()) {
            $comment
                ->setSubject($em->getRepository('UnsecureBundle:Subject')->findFull($subjectId))
                ->setUser($user)
            ;
            
            $em->persist($comment);
            $em->flush();
            
            return $this->redirect($request->getUri());
        }
        
        return $this->render('UnsecureBundle:Index:subject.html.twig', array(
            'subject' => $subject,
            'comments' => $em->getRepository('UnsecureBundle:Comment')->findCommentBySubject($subjectId),
            'commentForm' => $commentForm->createView(),
        ));
    }
}
