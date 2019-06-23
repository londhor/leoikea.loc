<?php

namespace frontend\widgets;

use yii\base\Widget;

class BannerWidget extends Widget
{
    public function run()
    {
        return $this->render('banner');
    }
}