<?php

return array(
    'mode'        => 'dev',
    'routes'      => include('routes.php'),
    'main_layout' => __DIR__.'/../../src/Blog/views/layout.html.php',
    'error_500'   => __DIR__.'/../../src/Blog/views/500.html.php',
    'pdo'         => array(
        'dsn'      => 'mysql:dbname=education;host=localhost;charset=latin1',
        'user'     => 'root',
        'password' => ''
    ),
    'security'    => array(
        'user_class'  => 'Blog\\Model\\User',
        'login_route' => 'login'
    )
);