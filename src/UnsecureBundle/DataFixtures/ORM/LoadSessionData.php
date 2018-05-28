<?php

namespace UnsecureBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use UnsecureBundle\Exception\Exception;
use UnsecureBundle\Entity\Session;

class LoadSessionData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $em)
    {
        $adminUser = $em->getRepository('UnsecureBundle:User')->findOneBy(array(
            'admin' => 1,
        ));
        
        if (null === $adminUser) {
            throw new Exception('There must have at least one admin user in database, please check your fixtures');
        }
        
        $session = new Session();
        
        $session->setData(json_encode((object) array(
            'userId' => $adminUser->getId(),
        )));
        
        $em->persist($session);
        $em->flush();
    }
}
