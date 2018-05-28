<?php

namespace UnsecureBundle\Service;

use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use UnsecureBundle\Entity\Session;
use UnsecureBundle\Entity\SessionRepository;
use UnsecureBundle\Entity\User;
use UnsecureBundle\Entity\UserRepository;

class SessionService
{
    /**
     * @var Request
     */
    private $request;
    
    /**
     * @var SessionRepository
     */
    private $sessionRepository;
    
    /**
     * @var UserRepository
     */
    private $userRepository;
    
    /**
     * @var Session
     */
    private $session;
    
    /**
     * @var boolean
     */
    private $logout;
    
    /**
     * Constructor
     * 
     * @param RequestStack $requestStack
     * @param SessionRepository $sessionRepository
     * @param UserRepository $userRepository
     */
    public function __construct(
        RequestStack $requestStack,
        SessionRepository $sessionRepository,
        UserRepository $userRepository
    ) {
        $this->request = $requestStack->getMasterRequest();
        $this->sessionRepository = $sessionRepository;
        $this->userRepository = $userRepository;
    }
    
    /**
     * Init current request session from cookie
     */
    public function initSession()
    {
        if (null === $this->session) {
            $sessionId = $this->request->cookies->get('sessionId');

            if (null !== $sessionId) {
                $this->session = $this->sessionRepository->find($sessionId);
            }
            
            if (null === $this->session) {
                $this->session = new Session();
                $this->setData(self::createDefaultSessionData());
            }
        }
    }
    
    /**
     * Init session on kernel controller
     */
    public function onKernelController()
    {
        $this->initSession();
    }
    
    /**
     * Persist session data into database,
     * and send cookie on kernel response
     * 
     * @param FilterResponseEvent $event
     */
    public function onKernelResponse(FilterResponseEvent $event)
    {
        $this->sessionRepository->saveSession($this->session);
        
        $response = $event->getResponse();
        
        $cookie = new Cookie('sessionId', $this->session->getId(), $this->logout ? time() - 3600 : time() + 3600 * 24);
        
        $response->headers->setCookie($cookie);
    }
    
    /**
     * @return \stdClass
     */
    public function getData()
    {
        return json_decode($this->session->getData());
    }
    
    /**
     * @param array $data
     * 
     * @return \stdClass
     */
    public function setData(\stdClass $data)
    {
        $this->session->setData(json_encode($data));
        $this->sessionRepository->saveSession($this->session);
    }
    
    /**
     * @return User|null
     */
    public function getUser()
    {
        $user = null;
        $sessionData = $this->getData();
        
        if (-1 !== $sessionData->userId) {
            $user = $this->userRepository->find($sessionData->userId);
        }
        
        return $user;
    }
    
    /**
     * Logout, next cookie will destroy client session cookie
     */
    public function logout()
    {
        $this->logout = true;
    }
    
    /**
     * Create default session data
     * 
     * @return \stdClass
     */
    private static function createDefaultSessionData()
    {
        return (object) array(
            'userId' => -1,
        );
    }
}
