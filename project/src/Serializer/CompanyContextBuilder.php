<?php

namespace App\Serializer;

use ApiPlatform\Core\Exception\RuntimeException;
use ApiPlatform\Core\Serializer\SerializerContextBuilderInterface;
use App\Entity\Company;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class CompanyContextBuilder implements \ApiPlatform\Core\Serializer\SerializerContextBuilderInterface
{


    public function __construct(private SerializerContextBuilderInterface $decorated,
                                private AuthorizationCheckerInterface $authorizationChecker,
    ) {}

    public function createFromRequest(Request $request, bool $normalization, ?array $extractedAttributes = null): array
    {
        $context = $this->decorated->createFromRequest($request, $normalization, $extractedAttributes);
        $resourceClass = $context['resource_class'] ?? null;
        if ($resourceClass === Company::class && isset($context['groups'])) {
            if($this->authorizationChecker->isGranted('ROLE_ADMIN')) {
                $context['groups'][] = 'admin:input';
            } else if ($this->authorizationChecker->isGranted('ROLE_CLIENT_1')) {
                $context['groups'] = [];
                $context['groups'][] = 'show:client1';
            } else if ($this->authorizationChecker->isGranted('ROLE_CLIENT_2')) {
                $context['groups'] = [];
                $context['groups'][] = 'show:client2';
            }
        }
        return $context;
    }
}
