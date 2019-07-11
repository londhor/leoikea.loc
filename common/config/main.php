<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'commonCache' => [
            'class' => 'yii\caching\FileCache',
            'cachePath' => '@common/runtime/cache',
        ],
        'db' => [
            'class' => 'yii\db\Connection',
        ],
        'dbIkea' => [
            'class' => 'yii\db\Connection',
        ],
        //'formatter' => [
        //    'class' => \yii\i18n\Formatter::class,
        //    'numberFormatterOptions' => [
        //        NumberFormatter::MIN_FRACTION_DIGITS => 0,
        //        NumberFormatter::MAX_FRACTION_DIGITS => 2,
        //    ],
        //    'numberFormatterSymbols' => [
        //        NumberFormatter::CURRENCY_SYMBOL => '₴',
        //    ],
        //],
        'fileStorage' => [
            'class' => \yii2tech\filestorage\hub\Storage::class,
            'storages' => [
                'productStorage' => [
                    'class' => \yii2tech\filestorage\local\Storage::class,
                    'basePath' => '@frontend/web/images',
                    'baseUrl' => '@web/images',
                    'buckets' => [
                        'products' => [
                            'baseSubPath' => 'products',
                        ],
                    ]
                ],
                'otherStorage' => [
                    'class' => \yii2tech\filestorage\local\Storage::class,
                    'basePath' => '@frontend/web/images',
                    'baseUrl' => '@web/images',
                    'dirPermission' => 0775,
                    'filePermission' => 0755,
                    'buckets' => [
                        'reviews' => [
                            'baseSubPath' => 'reviews',
                        ],
                        'our_clients' => [
                            'baseSubPath' => 'our_clients',
                        ],
                    ]
                ]
            ]
        ],
        'settings' => [
            'class' => 'yii2mod\settings\components\Settings',
            'cache' => 'commonCache',
            'cacheKey' => 'app.settings',
        ],
    ],
];
