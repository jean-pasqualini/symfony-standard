<?php
/**
 * Created by PhpStorm.
 * User: prestataire
 * Date: 15/06/16
 * Time: 15:45
 */

namespace AppBundle\EventListener;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;


/**
 * ExceptionListener
 *
 * @author Jean Pasqualini <jean.pasqualini@digitaslbi.fr>
 * @copyright 2016 DigitasLbi France
 * @package AppBundle\EventListener;
 */
class ExceptionListener
{
    protected $dispatcher;

    protected $responseListener;

    public function __construct(EventDispatcher $dispatcher, ResponseListener $responseListener)
    {
        $this->dispatcher = $dispatcher;

        $this->responseListener = $responseListener;
    }

    public function onKernelException(GetResponseForExceptionEvent $event)
    {

        if($event->getRequestType() == HttpKernelInterface::MASTER_REQUEST) {
            $this->responseListener->setRedirect( new RedirectResponse('http://google.fr/'));
            $this->dispatcher->dispatch('raaah', new Event());
            $response = new RedirectResponse('http://google.fr/');
            $event->setResponse($response);
            $event->stopPropagation();
        }

    }
}