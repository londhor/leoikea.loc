<?php
return [
    'controllerMap' => [
        'elfinder' => [
            'roots' => new \yii\helpers\ReplaceArrayValue([
                [
                    'baseUrl' => '', // Config in main-local
                    'basePath' => '@frontend/web/images',
                    'path' => 'articles',
                    'name' => 'Статті'
                ],
            ]),
        ]
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '',
        ],
    ],
];
