<?php

// Doctrine (db)
$app['db.options'] = array(
    'driver'   => 'pdo_mysql',
    'charset'  => 'utf8',
    'host'     => 'localhost',  
    'port'     => '3306',
    'dbname'   => 'CHANGE HERE YOUR DB NAME',
    'user'     => 'CHANGE HERE YOUR USER',
    'password' => 'CHANGE HERE YOUR PASSWORD'
);

// enable the debug mode
$app['debug'] = true;

// define log parameters
$app['monolog.level'] = 'INFO';
