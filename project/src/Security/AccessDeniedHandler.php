<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;

class AccessDeniedHandler implements AccessDeniedHandlerInterface
{

    /**
     * Appelé quand l'utilisateur n'est pas autorisé à accéder à une page
     * @inheritDoc
     */
    public function handle(Request $request, AccessDeniedException $accessDeniedException): ?Response
    {
        return new Response("<h1>Vous n'êtes pas autorisé à accéder à cette ressource</h1>
                                    <a href='/logout'>Déconnexion</a>", 403);
    }
}
