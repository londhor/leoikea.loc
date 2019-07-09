<?php

namespace console\controllers;

use common\models\shop\Product;
use yii\console\Controller;

class ProductsController extends Controller
{
    public function actionPrepare()
    {
        $start = microtime(true);

        $products = Product::find()
            ->with('image')
            ->orderBy(['parsed_at' => SORT_DESC, 'id' => SORT_ASC])
            ->limit(24)
            ->all();

        $end = microtime(true) - $start;

        echo 'Success' . PHP_EOL;
        echo 'Completed in ' . number_format($end, 3, '.', ' ') . 's';
        echo PHP_EOL;
    }
}