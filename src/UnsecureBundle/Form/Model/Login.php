<?php

namespace UnsecureBundle\Form\Model;

class Login
{
    /**
     * @var string
     */
    private $login;
    
    /**
     * @var string
     */
    private $pwd;

    /**
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @param string $login
     * 
     * @return self
     */
    public function setLogin($login)
    {
        $this->login = $login;
        
        return $this;
    }

    /**
     * @return string
     */
    public function getPwd()
    {
        return $this->pwd;
    }

    /**
     * @param string $pwd
     * 
     * @return self
     */
    public function setPwd($pwd)
    {
        $this->pwd = $pwd;
        
        return $this;
    }
}
