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

    public $ver = '1.0';

    public $css = [
        'css/normalize.css?ver=1',
        'css/main.css?ver',
        'css/adaptive.css?ver',
        'css/animations.css?ver',
        'css/icons.css?ver',
        'css/swiper.min.css?ver',
        'css/slimselect.css?ver',
    ];

    public $js = [
        'js/vue.js',
        'js/slimselect.js',
        'js/swiper.min.js',
        'js/scripts.js',
        'js/scrollLock.min.js',
        'js/phoneFormat.js',
    ];
}
