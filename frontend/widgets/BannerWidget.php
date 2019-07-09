<?php

namespace frontend\widgets;

use yii;
use frontend\components\ContentSettings;
use yii\base\Widget;

class BannerWidget extends Widget
{
    public function run()
    {
        $banner = $this->contentSettings()->getBanner();

        if ($banner['title'] === '' && $banner['description'] === '') {
            return '';
        }

        return $this->render('banner', $banner);
    }

    /**
     * @return ContentSettings
     */
    protected function contentSettings()
    {
        return Yii::$app->contentSettings;
    }
}