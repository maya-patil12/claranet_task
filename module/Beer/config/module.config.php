<?php
declare(strict_types=1);
namespace Beer;
use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
return [
    'router' => [
        'routes' => [
            'beer' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/beer[/:action[/:id]]',
                    'constraints'=>[
                        'action'=>'[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'=>'[0-9+]',
                    ],
                    'defaults' => [
                        'controller' => Controller\BeerController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
   
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
