<?php

namespace UnsecureBundle\Service;

use UnsecureBundle\Exception\LoginException;
use UnsecureBundle\Entity\UserRepository;

class LoginService
{
    /**
     * @var UserRepository
     */
    private $userRepository;
    
    /**
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    
    /**
     * Try to login with given credentials.
     * Return logged user or null if invalid credentials.
     * 
     * @param string $username
     * @param string $plainPassword
     * 
     * @return User
     * 
     * @throws LoginException
     */
    public function login($username, $plainPassword)
    {
        $loggedUser = $this->userRepository->loginQuery($username, self::hash($plainPassword));
        
        if (null !== $loggedUser) {
            return $loggedUser;
        }
        
        $existingUser = $this->userRepository->findOneBy(array(
            'pseudo' => $username,
        ));
        
        if (null === $existingUser) {
            throw new LoginException('Le nom d\'utilisateur n\'existe pas.');
        } else {
            throw new LoginException('Le nom d\'utilisateur existe mais le mot de passe n\'est pas le bon.');
        }
    }
    
    /**
     * @param string $plainPassword
     * 
     * @return string
     */
    private static function hash($plainPassword)
    {
        return md5($plainPassword);
    }
}
