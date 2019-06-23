<?php

namespace frontend\widgets;

use common\models\shop\Product;
use yii\base\Widget;

class CarouselWidget extends Widget
{
    public $title;

    public function run()
    {
        $products = Product::find()
            ->joinWith('image')
            ->orderBy(['views' => SORT_DESC, 'id' => SORT_ASC])
            ->groupBy('id')
            ->limit(8)
            ->all();

        if (!$products) {
            return '';
        }

        return $this->render('carousel', [
            'products' => $products,
            'title' => $this->title,
        ]);
    }
}