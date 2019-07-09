<?php

namespace frontend\widgets;

use common\models\shop\Product;
use yii;

/**
 * Popular products carousel
 * @package frontend\widgets
 */
class PopularProductsWidget extends CarouselWidget
{
    /**
     * @var string
     */
    public $cacheKey = 'products.popular';

    /**
     * @inheritdoc
     */
    public function init()
    {
        if ($this->title === null) {
            $this->title = Yii::t('app', 'Популярні товари');
        }

        parent::init();
    }

    /**
     * @return Product[]
     */
    protected function getProducts()
    {
        $productsQuery = Product::find()
            ->with('image')
            ->orderBy(['views' => SORT_DESC, 'id' => SORT_ASC]);

        if ($this->useCache && $this->cacheKey !== null && ($ids = Yii::$app->cache->get($this->cacheKey)) !== false) {
            $productsQuery->where([
                'id' => $ids,
            ]);
        }

        $products = $productsQuery
            ->limit($this->limitProducts)
            ->all();

        if (!$products) {
            return [];
        }

        if ($this->useCache && $this->cacheKey !== null) {
            Yii::$app->cache->set($this->cacheKey, yii\helpers\ArrayHelper::getColumn($products, 'id'), $this->cacheDuration);
        }

        return $products;
    }
}