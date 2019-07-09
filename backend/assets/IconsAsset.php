<?php

namespace backend\assets;

use yii;

class IconsAsset extends yii\web\AssetBundle
{
    public $sourcePath = '@frontend/web/static';

    public $publishOptions = [
        'only' => ['css/icons.css', 'fonts/icons/*'],
    ];

    public $css = [
        'css/icons.css',
    ];

    public static $icons = [
        'ic-m-minus'     => 'M-minus',
        'ic-m-plus'      => 'M-plus',
        'ic-arrow-down'  => 'Arrow-down',
        'ic-arrow-left'  => 'Arrow-left',
        'ic-arrow-right' => 'Arrow-right',
        'ic-arrow-up'    => 'Arrow-up',
        'ic-ben-1'       => 'Ben-1',
        'ic-ben-2'       => 'Ben-2',
        'ic-ben-3'       => 'Ben-3',
        'ic-ben-4'       => 'Ben-4',
        'ic-ben-5'       => 'Ben-5',
        'ic-ben-6'       => 'Ben-6',
        'ic-ben-7'       => 'Ben-7',
        'ic-bin'         => 'Bin',
        'ic-burger'      => 'Burger',
        'ic-cart-add'    => 'Cart-add',
        'ic-cart'        => 'Cart',
        'ic-category-1'  => 'Category-1',
        'ic-category-2'  => 'Category-2',
        'ic-category-3'  => 'Category-3',
        'ic-category-4'  => 'Category-4',
        'ic-category-5'  => 'Category-5',
        'ic-category-6'  => 'Category-6',
        'ic-category-7'  => 'Category-7',
        'ic-category-8'  => 'Category-8',
        'ic-category-9'  => 'Category-9',
        'ic-category-10' => 'Category-10',
        'ic-category-11' => 'Category-11',
        'ic-category-12' => 'Category-12',
        'ic-category-13' => 'Category-13',
        'ic-category-14' => 'Category-14',
        'ic-category-15' => 'Category-15',
        'ic-category-16' => 'Category-16',
        'ic-category-17' => 'Category-17',
        'ic-close'       => 'Close',
        'ic-logo-1'      => 'Logo-1',
        'ic-magnifier'   => 'Magnifier',
        'ic-mail'        => 'Mail',
        'ic-phone-call'  => 'Phone-call',
        'ic-phone'       => 'Phone',
        'ic-pin'         => 'Pin',
        'ic-instagram'   => 'Instagram',
        'ic-messenger'   => 'Messenger',
        'ic-facebook'    => 'Facebook',
        'ic-telegram'    => 'Telegram',
        'ic-viber'       => 'Viber',
        'ic-whatsapp'    => 'Whatsapp',
        'ic-404'         => '404',
    ];
}