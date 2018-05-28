<?php

namespace UnsecureBundle\Listener;

use Twig_Environment;
use UnsecureBundle\Service\SessionService;

class AddSessionDataTwigGlobal
{
    /**
     * @var SessionService
     */
    private $sessionService;
    
    /**
     * @var Twig_Environment
     */
    private $twig;
    
    /**
     * @param SessionService $sessionService
     * @param Twig_Environment $twig
     */
    public function __construct(SessionService $sessionService, Twig_Environment $twig)
    {
        $this->sessionService = $sessionService;
        $this->twig = $twig;
    }
    
    public function onKernelController()
    {
        $this->twig->addGlobal('sessionUser', $this->sessionService->getUser());
    }
}
