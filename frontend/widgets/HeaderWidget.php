<?php

namespace frontend\widgets;

use common\models\shop\Category;
use yii\base\Widget;
use yii;

/**
 * Header widget
 * @package frontend\widgets
 */
class HeaderWidget extends Widget
{
    /**
     * @return string
     */
    public function run()
    {
        $categories = Category::find()
            ->alias('parent')
            ->joinWith('subCategories as sub')
            ->where(['parent.parent_id' => null])
            ->all();

        return $this->render('header', [
            'categories' => $categories,
        ]);
    }
}