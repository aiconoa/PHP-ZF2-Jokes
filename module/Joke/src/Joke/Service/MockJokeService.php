<?php

namespace Joke\Service;


use Joke\Entity\Joke;
use Zend\Log\Logger;
use Zend\Log\Writer\Stream;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class MockJokeService implements JokeService, ServiceLocatorAwareInterface
{

    private $jokes = array();

    private $serviceLocator;
    /**
     * Set service locator
     *
     * @param ServiceLocatorInterface $serviceLocator
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
       $this->serviceLocator = $serviceLocator;
    }

    /**
     * Get service locator
     *
     * @return ServiceLocatorInterface
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }


    function __construct()
    {
        $joke = new Joke();
        $joke->setId(1);
        $joke->setTitle("Un couple se balade sur les Champs Élysée");
        $joke->setText("Un couple se balade sur les Champs Élysée quand tout à coup la femme s'arrête net devant une vitrine de robes.
Elle est émerveillée par une robe et le fait comprendre à son mari ! Son mari lui demande :
- Elle te plait ?
- Oh oui, elle est magnifique !
- Si tu veux demain on revient et tu pourras encore la regarder.");
        $joke->setPostedOn("01/01/14");
        $this->jokes[]= $joke;

        $joke = new Joke();
        $joke->setId(2);
        $joke->setTitle("Un chien et un crocodile se rencontrent");
        $joke->setText("Un chien et un crocodile se rencontrent :
- Salut, sac à puces !
- Salut, sac à main !");
        $joke->setPostedOn("02/01/14");
        $this->jokes[]= $joke;

        $joke = new Joke();
        $joke->setId(3);
        $joke->setTitle("Deux chefs d'entreprise discutent");
        $joke->setText("Deux chefs d'entreprise discutent:
- Comment fais-tu pour que tes employés arrivent toujours à l'heure le matin ?
- C'est très simple : j'ai trente employés et seulement vingt places de parking...");
        $joke->setPostedOn("02/01/14");
        $this->jokes[]= $joke;
    }


    public function findAllJokes()
    {
        return $this->jokes;
    }

    public function findJoke($id)
    {
        foreach($this->jokes as $joke) {
            if($joke->getId() === $id) {
                return $joke;
            }
        }

        return null;
    }

}