<?php

namespace frontend\widgets;

use yii;

class ProductWidget extends yii\base\Widget
{
    public $product;

    public function run()
    {
        if ($this->product === null) {
            return '';
        }

        return $this->render('product', [
            'product' => $this->product,
        ]);
    }
}