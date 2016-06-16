<?php
/**
 * Created by PhpStorm.
 * User: prestataire
 * Date: 15/06/16
 * Time: 16:05
 */

namespace AppBundle\EventListener;


use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;


/**
 * ResponseListener
 *
 * @author Jean Pasqualini <jean.pasqualini@digitaslbi.fr>
 * @copyright 2016 DigitasLbi France
 * @package AppBundle\EventListener;
 */
class ResponseListener
{
    protected $redirectRequest;

    public function setRedirect(RedirectResponse $redirectRequest)
    {
        $this->redirectRequest = $redirectRequest;
    }

    public function onResponse(FilterResponseEvent $event)
    {
        if($event->getRequestType() == HttpKernelInterface::MASTER_REQUEST) {
            if($this->redirectRequest)
            {
                $event->setResponse($this->redirectRequest);
            }
        }

    }
}