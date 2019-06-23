<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot/static';

    public $baseUrl = '@web/static';

    public $css = [
        'css/normalize.css',
        'css/main.css',
        'css/adaptive.css',
        'css/animations.css',
        'css/icons.css',
        'css/swiper.min.css',
        'css/slimselect.css',
    ];

    public $js = [
        'js/vue.js',
        'js/slimselect.js',
        'js/scripts.js',
        'js/swiper.min.js',
    ];
}
