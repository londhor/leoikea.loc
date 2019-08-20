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
        'css/normalize.css?ver=1.12',
        'css/main.css?ver=1.12',
        'css/adaptive.css?ver=1.12',
        'css/animations.css?ver=1.12',
        'css/icons.css?ver=1.12',
        'css/swiper.min.css?ver=1.12',
        'css/slimselect.css?ver=1.12',
    ];

    public $js = [
        'js/vue.js?ver=1.12',
        'js/slimselect.js?ver=1.12',
        'js/swiper.min.js?ver=1.12',
        'js/scripts.js?ver=1.12',
        'js/scrollLock.min.js?ver=1.12',
        'js/phoneFormat.js?ver=1.12',
    ];
}
