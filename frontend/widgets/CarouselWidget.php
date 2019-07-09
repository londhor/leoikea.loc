<?php

namespace frontend\widgets;

use common\models\shop\Product;
use yii\base\Widget;
use yii;

/**
 * Products carousel widget
 * @package frontend\widgets
 */
class CarouselWidget extends Widget
{
    /**
     * @var string Block title
     */
    public $title;

    /**
     * @var string
     */
    public $cacheKey = 'products.carousel';

    /**
     * @var int Cache duration in seconds. Default 15min
     */
    public $cacheDuration = 900;

    /**
     * @var bool
     */
    public $useCache = true;

    /**
     * @var int
     */
    public $limitProducts = 16;

    /**
     * @var array|string
     */
    public $detailUrl;

    /**
     * @var string
     */
    public $detailTitle;

    /**
     * @var array|string
     */
    public $lastItemUrl;

    /**
     * @var string
     */
    public $lastItemTitle;

    /**
     * @inheritdoc
     */
    public function run()
    {
        $products = $this->getProducts();

        if (!$products) {
            return '';
        }

        return $this->render('carousel', [
            'products' => $products,
            'title' => $this->title,
            'detailTitle' => $this->detailTitle,
            'detailUrl' => $this->detailUrl,
            'lastItemTitle' => $this->lastItemTitle,
            'lastItemUrl' => $this->lastItemUrl,
        ]);
    }

    /**
     * @return Product[]
     */
    protected function getProducts()
    {
        return [];
    }
}