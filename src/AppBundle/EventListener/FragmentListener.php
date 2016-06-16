<?php
/**
 * Created by PhpStorm.
 * User: prestataire
 * Date: 16/06/16
 * Time: 17:58
 */

namespace AppBundle\EventListener;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\EventListener\FragmentListener as SymfonyFragmentListener;
use Symfony\Component\HttpKernel\UriSigner;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;


/**
 * Catch sub-reqest exceptions
 */
class FragmentListener extends SymfonyFragmentListener
{
    private $signer;
    private $fragmentPath;

    /**
     * {@inheritdoc}
     */
    public function __construct(UriSigner $signer, $fragmentPath = '/_fragment')
    {
        parent::__construct($signer, $fragmentPath);

        $this->signer = $signer;
        $this->fragmentPath = $fragmentPath;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::EXCEPTION => array('onKernelException', 255),
        );
    }

    /**
     * Process the exception
     *
     * @param GetResponseForExceptionEvent $event The propagated event
     */
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $event->setResponse(new RedirectResponse('http://www.google.fr/'));
        return;
    }

    /**
     * {@inheritdoc}
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();

        if ($request->attributes->has('_controller')
            || $this->fragmentPath !== rawurldecode($request->getPathInfo())
        ) {
            return;
        }
        $event->getRequest()->attributes->set('esi', true);

        parent::onKernelRequest($event);
    }
}