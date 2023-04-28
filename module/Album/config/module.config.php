<?php
declare(strict_types=1);
namespace Album;
use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'album' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/album[/:action[/:id]]',
                    'constraints'=>[
                        'action'=>'[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'=>'[0-9+]',
                    ],
                    'defaults' => [
                        'controller' => Controller\AlbumController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    // 'controllers' => [
    //     'factories' => [
    //         AlbumController::class => InvokableFactory::class,
    //     ],
    // ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
