<?php

namespace metronic;

use yii;

/**
 * Class MetronicAsset
 *
 * @package backend\assets\metronic
 */
class MetronicAsset extends yii\web\AssetBundle
{
    public $basePath = '@webroot/metronic';

    public $baseUrl = '@web/metronic';

    public $js = [
        'vendors/bootstrap/dist/js/bootstrap.bundle.js',
        'vendors/block-ui/jquery.blockUI.js',
        YII_ENV_DEV ? 'assets/js/scripts.bundle.js' : 'assets/js/scripts.bundle.min.js',
        'vendors/perfect-scrollbar/dist/perfect-scrollbar.js',
        'vendors/jquery-validation/dist/jquery.validate.js',
        'vendors/jquery-validation/dist/localization/messages_ru.js',
        'vendors/jquery-validation/dist/additional-methods.js',
        'assets/vendors/custom/datatables/datatables.bundle.js',
        'vendors/jquery-form/src/jquery.form.js',
    ];

    public $css = [
        'assets/vendors/base/vendors.bundle.css',
        YII_ENV_DEV ? 'assets/css/style.bundle.css' : 'assets/css/style.bundle.min.css',
        'assets/css/style.css',
        'assets/vendors/custom/datatables/datatables.bundle.css',
    ];

    public $depends = [
        yii\web\YiiAsset::class,
        yii\jui\JuiAsset::class,
    ];
}