<?php
/**
 * Created by PhpStorm.
 * User: prestataire
 * Date: 15/06/16
 * Time: 15:45
 */

namespace AppBundle\EventListener;

use AppBundle\Exception\CustomException;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\KernelEvents;


/**
 * ExceptionListener
 *
 * @author Jean Pasqualini <jean.pasqualini@digitaslbi.fr>
 * @copyright 2016 DigitasLbi France
 * @package AppBundle\EventListener;
 */
class ExceptionListener implements EventSubscriberInterface
{
    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::EXCEPTION => array('onKernelException', 255),
        );
    }

    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        if($event->getException() instanceof \Twig_Error_Runtime)
        {
            if ($event->getException()->getPrevious() instanceof CustomException) {
                $event->setResponse(new RedirectResponse('http://google.fr/'));
            }
        }
    }
}