<?php

return [
    'db' => [
        'class' => 'RedCrown\Database\Database',
        'dsn' => sprintf("mysql:host=172.24.0.2;dbname=%s", getenv("MYSQL_DATABASE")),
        'username' => getenv("MYSQL_USER"),
        'password' => getenv("MYSQL_PASSWORD"),
        'tablePrefix' => 'rc_'
    ],
    'templater' => [
      'class' => 'RedCrown\Reader\PhpFileReader'
    ],
    'subscribers' => [
        'userEventHandler' => App\Event\UserEventHandler::class,
    ],
];
