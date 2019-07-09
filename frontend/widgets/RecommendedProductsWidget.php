<?php

namespace frontend\widgets;

use common\models\shop\Product;
use yii;

/**
 * Recommended products carousel
 * @package frontend\widgets
 */
class RecommendedProductsWidget extends CarouselWidget
{
    /**
     * @var Product
     */
    public $product;

    /**
     * @inheritdoc
     */
    public function init()
    {
        if ($this->title === null) {
            $this->title = Yii::t('app', 'Рекомендовані товари');
        }

        parent::init();
    }

    /**
     * @return Product[]
     */
    protected function getProducts()
    {
        if ($this->product === null) {
            return [];
        }

        $recommendedIds = $this->getRecommendedProductIds();

        $products = Product::find()
            ->with('image')
            ->where(['id' => $recommendedIds])
            ->orderBy(['views' => SORT_DESC, 'id' => SORT_ASC])
            ->limit($this->limitProducts)
            ->all();

        return $products;
    }

    /**
     * @return array
     */
    protected function getRecommendedProductIds()
    {
        $productIds = Product::find()
            ->select('id')
            ->where(['category_id' => $this->product->category_id])
            ->column();

        $randomIds = [];
        $count = count($productIds);
        $max = min($count, $this->limitProducts);

        for ($i = 0; $i < $max; $i++) {
            $randomIds[] = $productIds[rand(0, $count - 1)];
        }

        return $randomIds;
    }
}