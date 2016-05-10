<?php
$config['mongo'] = array(
    'host' => '127.0.0.1',
    'port' => 27017,
    'db' => 'zplay',
    'opt' => array(
        'connect' => true,
        'connectTimeoutMS' => 3000,
        'w' => 1,
        'wTimeout' => 2000,
    ),
);
