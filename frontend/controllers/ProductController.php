<?php

namespace frontend\controllers;

use yii;
use common\models\shop\Product;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ProductController extends Controller
{
    public function actionIndex($key)
    {
        $product = $this->findProduct($key);

        $this->view->title = sprintf('%s. %s | %s | %s', $product->titleLang, $product->descrLang, 'Доставка з Ikea', Yii::$app->name);
        $this->view->registerMetaTag([
            'name' => 'description',
            'content' => sprintf('%s. %s | %s | %s', $product->titleLang, $product->descrLang, 'Доставка з Ikea', Yii::$app->name),
        ]);

        $this->updateViews($product);

        return $this->render('index', [
            'product' => $product
        ]);
    }

    protected function findProduct($key)
    {
        $product = Product::findOne(['id' => $key]);

        if ($product === null) {
            throw new NotFoundHttpException('Страница не найдена');
        }

        return $product;
    }

    /**
     * @param Product $product
     */
    protected function updateViews($product)
    {
        $views = Yii::$app->session->get('Product.views');

        if (!is_array($views)) {
            $views = [];
        }

        //if ($views === [] || !isset($views[$product->id]) || $views[$product->id] < strtotime('1 day ago')) {
        //    $product->updateCounters(['views' => 1]);
        //    $views[$product->id] = time();
        //
        //    Yii::$app->session->set('Product.views', $views);
        //}
    }
}