<?php

namespace metronic;

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

class Layout
{
    protected static $additionalOptions;

    public static function getHtmlOptions($section, $options = [], $asString = true)
    {
        $callback = sprintf('static::_get%sDefaultOptions', ucfirst(strtolower($section)));

        $defaultOptions = call_user_func($callback);
        $additionalOptions = isset(self::$additionalOptions[$section]) ? self::$additionalOptions[$section] : [];
        $htmlOptions = ArrayHelper::merge($defaultOptions, $additionalOptions, $options);

        return $asString ? Html::renderTagAttributes($htmlOptions) : $htmlOptions;
    }

    public static function addHtmlOptions($section, $options)
    {
        $callback = sprintf('static::_add%sOptions', ucfirst(strtolower($section)));

        call_user_func($callback);
    }

    private static function getBodyDefaultOptions()
    {
        $options = [];

        Html::addCssClass($options, 'm--skin-');
        Html::addCssClass($options, 'm-header--fixed');
        Html::addCssClass($options, 'm-header--fixed-mobile');
        Html::addCssClass($options, 'm-aside-left--enabled');
        Html::addCssClass($options, 'm-aside-left--skin-dark');
        Html::addCssClass($options, 'm-aside-left--fixed');
        Html::addCssClass($options, 'm-aside-left--offcanvas');
        Html::addCssClass($options, 'm-footer--push');
        Html::addCssClass($options, 'm-aside--offcanvas-default');

        return $options;
    }

    private static function addBodyOptions($options)
    {
        self::$additionalOptions['body'] = ArrayHelper::merge(isset(self::$additionalOptions['body']) ? self::$additionalOptions['body'] : [], $options);
    }
}
