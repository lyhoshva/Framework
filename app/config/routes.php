<?php

use Shop\Model\Roles;

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
        'security'   => [Roles::ROLE_ADMIN],
    ],
    'update_product'    => [
        'pattern'    => '/products/update/{id}',
        'controller' => 'Shop\\Controller\\ProductController',
        'action'     => 'update',
        'security'   => [Roles::ROLE_ADMIN],
        '_requirements' => [
            'id' => '\d+',
        ],
    ],
    'delete_product'    => [
        'pattern'    => '/products/delete/{id}',
        'controller' => 'Shop\\Controller\\ProductController',
        'action'     => 'delete',
        'methods'    => ['POST'],
        'security'   => [Roles::ROLE_ADMIN],
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
        'security'   => [Roles::ROLE_ADMIN],
    ],
    'manufacturers_create'  => [
        'pattern'    => '/manufacturers/create',
        'controller' => 'Shop\\Controller\\ManufacturerController',
        'action'     => 'create',
        'security'   => [Roles::ROLE_ADMIN],
    ],
    'manufacturers_update'  => [
        'pattern'    => '/manufacturers/update/{id}',
        'controller' => 'Shop\\Controller\\ManufacturerController',
        'action'     => 'update',
        'security'   => [Roles::ROLE_ADMIN],
        '_requirements' => [
            'id' => '\d+',
        ],
    ],
    'manufacturers_delete'  => [
        'pattern'    => '/manufacturers/delete/{id}',
        'controller' => 'Shop\\Controller\\ManufacturerController',
        'action'     => 'delete',
        'methods'    => ['POST'],
        'security'   => [Roles::ROLE_ADMIN],
        '_requirements' => [
            'id' => '\d+',
        ],
    ],
    'add_to_cart' => [
        'pattern'    => '/cart/add/{id}',
        'controller' => 'Shop\\Controller\\CartController',
        'action'     => 'add',
        'methods'    => ['POST'],
        '_requirements' => [
            'id' => '\d+',
        ],
    ],
    'clear_cart' => [
        'pattern'    => '/cart/clear',
        'controller' => 'Shop\\Controller\\CartController',
        'action'     => 'clear',
        'methods'    => ['POST'],
    ],
    'cart_delete' => [
        'pattern'    => '/cart/delete/{id}',
        'controller' => 'Shop\\Controller\\CartController',
        'action'     => 'delete',
        'methods'    => ['POST'],
        '_requirements' => [
            'id' => '\d+',
        ],
    ],
    'cart_set_count' => [
        'pattern'    => '/cart/set/{id}/{count}',
        'controller' => 'Shop\\Controller\\CartController',
        'action'     => 'setProductCount',
        'methods'    => ['POST'],
        '_requirements' => [
            'id' => '\d+',
            'count' => '\d+',
        ],
    ],
    'cart_list' => [
        'pattern'    => '/cart',
        'controller' => 'Shop\\Controller\\CartController',
        'action'     => 'list',
    ],
    'order_create' => [
        'pattern'    => '/order/create',
        'controller' => 'Shop\\Controller\\OrderController',
        'action'     => 'create',
        'security'   => [Roles::ROLE_USER, Roles::ROLE_ADMIN],
    ],
    'order_update' => [
        'pattern'    => '/order/update/{id}',
        'controller' => 'Shop\\Controller\\OrderController',
        'action'     => 'update',
        'security'   => [Roles::ROLE_ADMIN],
        '_requirements' => [
            'id' => '\d+',
        ],
    ],
    'order_list' => [
        'pattern'    => '/order/list',
        'controller' => 'Shop\\Controller\\OrderController',
        'action'     => 'list',
        'security'   => [Roles::ROLE_ADMIN],
        '_requirements' => [
            'id' => '\d+',
        ],
    ],
    'order_show' => [
        'pattern'    => '/order/{id}',
        'controller' => 'Shop\\Controller\\OrderController',
        'action'     => 'show',
        'security'   => [Roles::ROLE_ADMIN],
        '_requirements' => [
            'id' => '\d+',
        ],
    ],
    'signup'         => [
        'pattern'    => '/signup',
        'controller' => 'Shop\\Controller\\SecurityController',
        'action'     => 'signup',
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