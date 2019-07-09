<?php

namespace frontend\widgets;

use common\models\shop\Product;
use yii;

/**
 * Novelty products carousel
 * @package frontend\widgets
 */
class NoveltyProductsWidget extends CarouselWidget
{
    /**
     * @var string
     */
    public $cacheKey = 'products.novelty';

    /**
     * @inheritdoc
     */
    public function init()
    {
        if ($this->title === null) {
            $this->title = Yii::t('app', 'Нові надходження');
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
            ->orderBy(['parsed_at' => SORT_DESC, 'id' => SORT_DESC]);

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