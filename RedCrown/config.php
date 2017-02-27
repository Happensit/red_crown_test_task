<?php

return [
    'db' => [
        'class' => 'RedCrown\Database\Database',
        'dsn' => sprintf("mysql:host=172.24.0.2;dbname=%s", getenv("MYSQL_DATABASE")), // 'mysql:host=172.23.0.2;dbname=redcrown',
        'username' => getenv("MYSQL_USER"),
        'password' => getenv("MYSQL_PASSWORD"),
        'tablePrefix' => 'rc_'
    ],
    'templater' => [
      'class' => 'RedCrown\Reader\PhpFileReader'
    ],
    'subscribers' => [
        'exceptionEventHandler' => RedCrown\Exception\ExceptionEventHandler::class,
        'userEventHandler' => App\Event\UserEventHandler::class,
    ],
];