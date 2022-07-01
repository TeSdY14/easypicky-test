<?php

namespace App\Doctrine;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryItemExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use App\Entity\Company;
use App\Entity\User;
use App\Entity\UserIsInCompanyInterface;
use Doctrine\ORM\QueryBuilder;
use ReflectionException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Security;

class UserInCompanyExtension implements QueryCollectionExtensionInterface, QueryItemExtensionInterface
{

    public function __construct(private Security $security)
    {}

    /**
     * The user can only show the informations about his company
     * @param QueryBuilder $queryBuilder
     * @param QueryNameGeneratorInterface $queryNameGenerator
     * @param string $resourceClass
     * @param string|null $operationName
     * @return void
     * @throws ReflectionException
     */
    public function applyToCollection(
        QueryBuilder $queryBuilder,
        QueryNameGeneratorInterface $queryNameGenerator,
        string $resourceClass,
        string $operationName = null
    ): void
    {
        $this->checkUserAndAddWhereParameter($resourceClass, $queryBuilder);
    }

    /**
     * @throws ReflectionException
     */
    public function applyToItem(
        QueryBuilder $queryBuilder,
        QueryNameGeneratorInterface $queryNameGenerator,
        string $resourceClass,
        array $identifiers, string $operationName = null, array $context = [],
    ): void
    {
        $this->checkUserAndAddWhereParameter($resourceClass, $queryBuilder);
    }

    /**
     * @throws ReflectionException
     */
    private function checkUserAndAddWhereParameter(string $resourceClass, QueryBuilder $queryBuilder,) {
        $reflectionClass = new \ReflectionClass($resourceClass);
        /* @var User $user */
        $user = $this->security->getUser();
        if ($user) {
            if ($reflectionClass->implementsInterface(UserIsInCompanyInterface::class) && $user->getRoles()[0] !== 'ROLE_ADMIN') {
                $queryBuilder->andWhere(sprintf('%s.id = :current_user', $queryBuilder->getRootAliases()[0]))
                    ->setParameter('current_user', $user->getCompany()->getId());
            }
        } else {
            $queryBuilder->andWhere(sprintf('1 = 0'));
        }
    }

}
