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
        'security'   => ['ROLE_ADMIN'],
    ],
    'update_product'    => [
        'pattern'    => '/products/update/{id}',
        'controller' => 'Shop\\Controller\\ProductController',
        'action'     => 'update',
        'security'   => ['ROLE_ADMIN'],
        '_requirements' => [
            'id' => '\d+',
        ],
    ],
    'delete_product'    => [
        'pattern'    => '/products/delete/{id}',
        'controller' => 'Shop\\Controller\\ProductController',
        'action'     => 'delete',
        'security'   => ['ROLE_ADMIN'],
        '_requirements' => [
            'id' => '\d+', //TODO Add Method POST
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
        'security'   => ['ROLE_ADMIN'],
    ],
    'manufacturers_create'  => [
        'pattern'    => '/manufacturers/create',
        'controller' => 'Shop\\Controller\\ManufacturerController',
        'action'     => 'create',
        'security'   => ['ROLE_ADMIN'],
    ],
    'manufacturers_update'  => [
        'pattern'    => '/manufacturers/update/{id}',
        'controller' => 'Shop\\Controller\\ManufacturerController',
        'action'     => 'update',
        'security'   => ['ROLE_ADMIN'],
        '_requirements' => [
            'id' => '\d+',
        ],
    ],
    'manufacturers_delete'  => [
        'pattern'    => '/manufacturers/delete/{id}',
        'controller' => 'Shop\\Controller\\ManufacturerController',
        'action'     => 'delete',
        'security'   => ['ROLE_ADMIN'],
        '_requirements' => [
            'id' => '\d+', //TODO Add Method POST
        ],
    ],
    'add_to_cart' => [
        'pattern'    => '/cart/add/{id}',
        'controller' => 'Shop\\Controller\\CartController',
        'action'     => 'add',
        '_requirements' => [
            'id' => '\d+', //TODO Add Method POST
        ],
    ],
    'clear_cart' => [
        'pattern'    => '/cart/clear',
        'controller' => 'Shop\\Controller\\CartController',
        'action'     => 'clear',
    ],
    'cart_delete' => [
        'pattern'    => '/cart/delete/{id}',
        'controller' => 'Shop\\Controller\\CartController',
        'action'     => 'delete',
        '_requirements' => [
            'id' => '\d+', //TODO Add Method POST
        ],
    ],
    'cart_set_count' => [
        'pattern'    => '/cart/set/{id}/{count}',
        'controller' => 'Shop\\Controller\\CartController',
        'action'     => 'setProductCount',
        '_requirements' => [
            'id' => '\d+', //TODO Add Method POST
            'count' => '\d+', //TODO Add Method POST
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
        'security'   => ['ROLE_USER', 'ROLE_ADMIN'],
    ],
    'order_update' => [
        'pattern'    => '/order/update/{id}',
        'controller' => 'Shop\\Controller\\OrderController',
        'action'     => 'update',
        'security'   => ['ROLE_ADMIN'],
        '_requirements' => [
            'id' => '\d+', //TODO Add Method POST
        ],
    ],
    'order_list' => [
        'pattern'    => '/order/list',
        'controller' => 'Shop\\Controller\\OrderController',
        'action'     => 'list',
        'security'   => ['ROLE_ADMIN'],
        '_requirements' => [
            'id' => '\d+', //TODO Add Method POST
        ],
    ],
    'order_show' => [
        'pattern'    => '/order/{id}',
        'controller' => 'Shop\\Controller\\OrderController',
        'action'     => 'show',
        'security'   => ['ROLE_ADMIN'],
        '_requirements' => [
            'id' => '\d+', //TODO Add Method POST
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
        'action'     => 'login', //TODO Add Method POST
    ],
    'logout'         => [
        'pattern'    => '/logout',
        'controller' => 'Shop\\Controller\\SecurityController',
        'action'     => 'logout', //TODO Add Method POST
    ],
];