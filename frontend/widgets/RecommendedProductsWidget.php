<?php

namespace frontend\widgets;

use common\models\shop\Product;
use common\models\shop\ProductToCategory;
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
            ->andWhere(['is','deleted', NULL])
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
        $categoryQuery = ProductToCategory::find()
            ->select(['product_id'])
            ->where(['category_id' => $this->product->category_id])
            ->all();

        $_ids = [];

        foreach ($categoryQuery as $catq) {
            $_ids[] = $catq->product_id;
        }

        $productIds = Product::find()
            ->select('id')
            ->where(['id' => $_ids])
            ->andWhere(['is','deleted', NULL])
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