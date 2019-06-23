<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=ikea',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ],
        'dbIkea' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=ikea_products',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
        ],
        'fileStorage' => [
            'baseUrl' => 'https://domain.com/images',
        ],
    ],
];
