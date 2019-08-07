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
            'class' => frontend\components\multilang\Request::class,
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
                        'app'            => 'app.php',
                        'app/product'    => 'app/product.php',
                        'app/cart'       => 'app/cart.php',
                        'app/search'     => 'app/search.php',
                        'app/metafields' => 'app/metafields.php',
                    ],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'class' => frontend\components\multilang\UrlManager::class,
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => true,
            'rules' => [
                '' => 'site/index',
                'contacts' => 'site/contacts',
                'sitemap' => 'sitemap/index',
                'catalog' => 'catalog/index',
                'catalog/search' => 'catalog/search',
                'catalog/category/<path[\w\-]+>' => 'catalog/category',
                'sale' => 'catalog/sale',
                'article/<key:[\w\-]+>' => 'article/view',
                'product/<key:[\w]+>' => 'product/index',
            ],
        ],
        //'formatter' => [
        //   'numberFormatterOptions' => [
        //       NumberFormatter::MAX_FRACTION_DIGITS => 0,
        //   ],
        //   'numberFormatterSymbols' => [
        //       NumberFormatter::CURRENCY_SYMBOL => '₴',
        //   ],
        //],
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
