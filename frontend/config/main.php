<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'language' => 'uk-UA',
    'sourceLanguage' => 'uk-UA',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'frontend',
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
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'fileMap' => [
                        'app'       => 'app.php',
                        'app/error' => 'error.php',
                    ],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => true,
            'rules' => [
                '' => 'site/index',
                'contacts' => 'site/contacts',
                'catalog' => 'catalog/index',
                'catalog/search' => 'catalog/search',
                'catalog/category/<path[\w\-]+>' => 'catalog/category',
                'article/<key:[\w\-]+>' => 'article/view',
                'product/<key:[\w]+>' => 'product/index',
            ],
        ],
        'formatter' => [
            'numberFormatterOptions' => [
                NumberFormatter::MAX_FRACTION_DIGITS => 0,
            ],
            'numberFormatterSymbols' => [
                NumberFormatter::CURRENCY_SYMBOL => '₴',
            ],
        ],
        'priceSettings' => [
            'class' => frontend\components\PriceSettings::class,
        ],
        'contentSettings' => [
            'class' => frontend\components\ContentSettings::class,
        ],
        'metaFieldsSettings' => [
            'class' => frontend\components\MetaFieldsSettings::class,
        ],
    ],
    'params' => $params,
];
