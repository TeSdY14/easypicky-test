<?php

namespace App\OpenApi;

use ApiPlatform\Core\OpenApi\Factory\OpenApiFactoryInterface;
use ApiPlatform\Core\OpenApi\OpenApi;
use ApiPlatform\Core\OpenApi\Model;

class JwtDecorator implements \ApiPlatform\Core\OpenApi\Factory\OpenApiFactoryInterface
{

    public function __construct(
        private OpenApiFactoryInterface $decorated,
    ) {}

    /**
     * @inheritDoc
     */
    public function __invoke(array $context = []): OpenApi
    {
        $openApi = ($this->decorated)($context);
        $schemas = $openApi->getComponents()->getSchemas();

        /* Advise users */
        $pathItem = $openApi->getPaths()->getPath('/api/companies/{id}');
        $operation = $pathItem->getPatch();
        $openApi->getPaths()->addPath('/api/companies/{id}', $pathItem->withPatch(
            $operation->withDescription('Only Admin user can query this operation !')
        ));

        foreach($openApi->getPaths()->getPaths() as $key => $path) {
            if ($path->getGet() && $path->getGet()->getSummary() === 'hidden') {
                $openApi->getPaths()->addPath($key, $path->withGet(null));
            }

            $schemas['Token'] = new \ArrayObject([
                'type' => 'object',
                'properties' => [
                    'token' => [
                        'type' => 'string',
                        'readOnly' => true,
                    ],
                ],
            ]);

            $schemas['bearerAuth'] = new \ArrayObject([
                'type' => 'http',
                'scheme' => 'bearer',
                'bearerFormat' => 'JWT',
            ]);

            /* Simple information schema for credentials */
            $schemas = $openApi->getComponents()->getSchemas();
            $schemas['Credentials'] = new \ArrayObject([
                'type' => 'object',
                'properties' => [
                    'username' => [
                        'type' => 'string',
                        'example' => 'admin@easypicky.fr',
                    ],
                    'password' => [
                        'type' => 'string',
                        'example' => 'pouet',
                    ]
                ],
            ]);

            $pathItem = new Model\PathItem(
                ref: 'JWT Token',
                post: new Model\Operation(
                    operationId: 'postCredentialsItem',
                    tags: ['Token'],
                    responses: [
                        '200' => [
                            'description' => 'Get JWT token',
                            'content' => [
                                'application/json' => [
                                    'schema' => [
                                        '$ref' => '#/components/schemas/Token',
                                    ],
                                ],
                            ],
                        ],
                    ],
                    summary: 'Get JWT token to login.',
                    requestBody: new Model\RequestBody(
                        description: 'Generate new JWT Token',
                        content: new \ArrayObject([
                            'application/json' => [
                                'schema' => [
                                    '$ref' => '#/components/schemas/Credentials',
                                ],
                            ],
                        ]),
                    ),
                ),
            );
        }



        $openApi->getPaths()->addPath('/api/login', $pathItem);

        return $openApi;
    }
}
