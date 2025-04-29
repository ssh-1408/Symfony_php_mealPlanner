<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Http\Event\LogoutEvent;

class LogoutSuccessListener
{
    private RouterInterface $router;
    private RequestStack $requestStack;

    public function __construct(RouterInterface $router, RequestStack $requestStack)
    {
        $this->router = $router;
        $this->requestStack = $requestStack;
    }

    public function onLogoutSuccess(LogoutEvent $event): void
    {
        $request = $this->requestStack->getMainRequest();
        
        if ($request !== null) {
            $session = $request->getSession(false); 
            
            if ($session !== null) {
                $session->getFlashBag()->add('success', 'You have been logged out successfully.');
            }
        }

        $event->setResponse(new RedirectResponse($this->router->generate('app_index')));

   
    }
}
