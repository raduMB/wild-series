<?php

namespace App\Controller\SecurityControllers;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;

class LoginSuccessHandler implements AuthenticationSuccessHandlerInterface
{
    private UrlGeneratorInterface $urlGenerator;

    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token): ?Response
    {
        // Retrieve the authenticated user
        $user = $token->getUser();

        // Check the user's roles
        if (in_array('ROLE_ADMIN', $user->getRoles())) {
            // Redirect the admin user to the admin dashboard
            return new RedirectResponse($this->urlGenerator->generate('admin_index'));
        } elseif (in_array('ROLE_CONTRIBUTOR', $user->getRoles())) {
            // Redirect the contributor user to the user dashboard
            return new RedirectResponse($this->urlGenerator->generate('user_index'));
        }

        // Redirect other users to a default page
        return new RedirectResponse($this->urlGenerator->generate('app_index'));
    }
}
