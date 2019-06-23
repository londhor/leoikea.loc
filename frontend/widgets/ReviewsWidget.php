<?php

namespace frontend\widgets;

use yii\base\Widget;

class ReviewsWidget extends Widget
{
    public function run()
    {
        return $this->render('reviews');
    }
}