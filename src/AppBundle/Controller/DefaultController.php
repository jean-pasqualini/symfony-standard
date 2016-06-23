<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Buzz\Browser;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        /** @var Browser $browser */
        $browser = $this->container->get('buzz');

        $browser->get('http://www.laposte.fr/particulier/');

        $browser->post('http://www.laposte.fr/particulier/', array(
            'enteteA' => 'valeurA'
        ),
        array(
            'data-a' => 'value a'
        ));

        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ));
    }

    /**
     * @Route("/casA", name="casA")
     */
    public function casAAction(Request $request)
    {
        $response = new Response();

        $response->setPublic();

        $response->setSharedMaxAge(86400);

        return $this->render('AppBundle::casA.html.twig', array(), $response);
    }

    /**
     * @Route("/casB", name="casB")
     */
    public function casBAction(Request $request)
    {
        $response = new Response();

        $response->setPublic();

        $response->setSharedMaxAge(86400);

        return $this->render('AppBundle::casB.html.twig', array(), $response);
    }

    public function blockAAction()
    {
        $response = new Response();

        $response->setPublic();

        $response->setSharedMaxAge(0);

        $response->setContent('block A dynamic, uniqid() = '.uniqid());

        return $response;
    }

    public function blockBAction()
    {
        $response = new Response();

        $response->setContent('block B dynamic, uniqid() = '.uniqid());

        return $response;
    }
}
