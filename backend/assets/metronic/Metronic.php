<?php

namespace metronic;

use yii;
use yii\web\AssetBundle;
use yii\web\View;

class Metronic extends yii\base\Component
{
    /**
     * @var MetronicAsset|null
     */
    public static $assetsBundle;

    public function init()
    {

    }

    /**
     * @param $view
     * @return MetronicAsset
     */
    public static function getAssetBundle($view)
    {
        if (static::$assetsBundle === null) {
            static::$assetsBundle = static::registerThemeAsset($view);
        }

        return (static::$assetsBundle instanceof AssetBundle) ? static::$assetsBundle : null;
    }

    /**
     * @param $view View
     * @param $path string
     * @return string
     */
    public static function getAssetsUrl($view, $path = '')
    {
        $assetsBundle = self::getAssetBundle($view);

        if ($assetsBundle) {
            if ($path) {
                $path = '/' . ltrim($path, '/');
            }

            return $assetsBundle->baseUrl . $path;
        }

        return '';
    }

    /**
     * @param $view View
     * @return MetronicAsset
     */
    public static function registerThemeAsset($view)
    {
        return static::$assetsBundle = MetronicAsset::register($view);
    }

    /**
     * @param $view View
     * @param $path string
     */
    public static function registerJsFile($view, $path)
    {
        $assetsBundle = self::getAssetBundle($view);

        if ($assetsBundle) {
            if (!YII_ENV_DEV && strrpos($path, '.min.js') === false) {
                $new_file = str_replace('.js', '.min.js', $path);

                if (is_file($assetsBundle->sourcePath . '/' . ltrim($new_file, '/'))) {
                    $path = $new_file;
                }
            }

            $assetsBundle->js[] = $path;
        }
    }
}