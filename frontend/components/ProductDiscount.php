<?php

namespace frontend\components;

/**
 * Component for product discounts
 */
class ProductDiscount extends \yii\base\Component
{
    /**
     * @var bool|null
     */
    protected $_hasDiscount;

    /**
     * @var float|null
     */
    protected $_discount;

    /**
     * Init Shop discount component
     * Puts discount value and determines it
     */
    public function init()
    {
        $this->_hasDiscount = false;
        $this->_discount = 10 / 100;
    }

    /**
     * @return bool Return true if discount is active
     */
    public function hasDiscount()
    {
        return $this->_hasDiscount;
    }

    /**
     * @param float $price Product price
     * @return float|int product price with discount ($price - N%)
     */
    public function calcPrice($price)
    {
        return (1 - $this->_discount) * $price;
    }
}