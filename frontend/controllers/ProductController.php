<?php

namespace frontend\controllers;

use frontend\components\MetaFieldsSettings;
use WhichBrowser\Parser;
use yii;
use common\models\shop\Product;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ProductController extends Controller
{
    public function actionIndex($key)
    {
        $product = $this->findProduct($key);

        /** @var MetaFieldsSettings $metaFieldsSettings */
        $metaFieldsSettings = Yii::$app->metaFieldsSettings;
        $metaFieldsSettings->generateForProduct($product);

        $this->updateViews($product);
        $detector = new Parser(Yii::$app->request->userAgent);

        return $this->render('index', [
            'product' => $product,
            'isMobile' => $detector->isMobile(),
        ]);
    }

    protected function findProduct($key)
    {
        $product = Product::findOne(['id' => $key]);

        if ($product === null) {
            throw new NotFoundHttpException(Yii::t('app', 'Страница не найдена'));
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

        if ($views === [] || !isset($views[$product->id]) || $views[$product->id] < strtotime('1 day ago')) {
            $product->updateCounters(['views' => 1]);
            $views[$product->id] = time();

            Yii::$app->session->set('Product.views', $views);
        }
    }
}