<?php

return [
    'home'           => [
        'pattern'    => '/',
        'controller' => 'Shop\\Controller\\ProductController',
        'action'     => 'list',
    ],
    'create_product'    => [
        'pattern'    => '/products/create',
        'controller' => 'Shop\\Controller\\ProductController',
        'action'     => 'create',
    ],
    'update_product'    => [
        'pattern'    => '/products/update/{id}',
        'controller' => 'Shop\\Controller\\ProductController',
        'action'     => 'update',
        '_requirements' => [
            'id' => '\d+',
        ],
    ],
    'delete_product'    => [
        'pattern'    => '/products/delete/{id}',
        'controller' => 'Shop\\Controller\\ProductController',
        'action'     => 'delete',
        '_requirements' => [
            'id' => '\d+',
        ],
    ],
    'product'           => [
        'pattern'    => '/products/{id}',
        'controller' => 'Shop\\Controller\\ProductController',
        'action'     => 'show',
        '_requirements' => [
            'id' => '\d+',
        ],
    ],
    'manufacturers_list'  => [
        'pattern'    => '/manufacturers',
        'controller' => 'Shop\\Controller\\ManufacturerController',
        'action'     => 'list',
    ],
    'manufacturers_create'  => [
        'pattern'    => '/manufacturers/create',
        'controller' => 'Shop\\Controller\\ManufacturerController',
        'action'     => 'create',
    ],
    'manufacturers_update'  => [
        'pattern'    => '/manufacturers/update/{id}',
        'controller' => 'Shop\\Controller\\ManufacturerController',
        'action'     => 'update',
        '_requirements' => [
            'id' => '\d+',
        ],
    ],
    'manufacturers_delete'  => [
        'pattern'    => '/manufacturers/delete/{id}',
        'controller' => 'Shop\\Controller\\ManufacturerController',
        'action'     => 'delete',
        '_requirements' => [
            'id' => '\d+',
        ],
    ],
    'signin'         => [
        'pattern'    => '/signin',
        'controller' => 'Shop\\Controller\\SecurityController',
        'action'     => 'signin',
    ],
    'login'          => [
        'pattern'    => '/login',
        'controller' => 'Shop\\Controller\\SecurityController',
        'action'     => 'login',
    ],
    'logout'         => [
        'pattern'    => '/logout',
        'controller' => 'Shop\\Controller\\SecurityController',
        'action'     => 'logout',
    ],
];