<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'language' => 'uk-UA',
    'sourceLanguage' => 'uk-UA',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'controllerMap' => [
        'elfinder' => [
            'class' => mihaildev\elfinder\Controller::class,
            'access' => ['@'],
            'disabledCommands' => ['netmount'],
            'roots' => [
                [
                    'baseUrl' => '@web', // Config in main-local
                    'basePath' => '@frontend/web/images/',
                    'path' => 'articles',
                    'name' => 'Статті'
                ],
            ],
        ]
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrfb',
        ],
        'user' => [
            'identityClass' => \backend\models\Manager::class,
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identityb', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '' => 'site/index',
                '<_a:(login|logout)>' => 'site/<_a>',
                '<_c:[\w-]+>' => '<_c>/index',
                '<_c:[\w-]+>/<_a:[\w-]+>' => '<_c>/<_a>',
            ],
        ],
    ],
    'params' => $params,
];
