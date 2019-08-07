<?php

namespace frontend\components;

use frontend\components\multilang\Languages;
use yii;
use yii2mod\settings\components\Settings;

/**
 * Component for product price
 */
class PriceSettings extends \yii\base\Component
{
    const PRICE_SECTION = 'price';

    /**
     * @var bool|null
     */
    protected $_hasDiscount;

    /**
     * @var float|null
     */
    protected $_discount;

    /**
     * @var string
     */
    protected $_discountDescription;

    /**
     * @var float|null
     */
    protected $_currencyRate;

    /**
     * Init Shop discount component
     * Puts discount value and determines it
     */
    public function init()
    {
    }

    /**
     * @return bool Return true if discount is active
     */
    public function hasDiscount()
    {
        if ($this->_hasDiscount !== null) {
            return $this->_hasDiscount;
        }

        $discount = (float) $this->settings()->get(self::PRICE_SECTION, 'discountPercent', null);

        if ($discount <= 0) {
            $this->_hasDiscount = false;
            $this->_discount = 0;
        } else {
            $this->_hasDiscount = true;
            $this->_discount = $discount / 100;
        }

        return $this->_hasDiscount;
    }

    /**
     * @return bool
     */
    public function hasDiscountDescription()
    {
        if (!$this->hasDiscount()) {
            return false;
        }

        if ($this->_discountDescription === null) {
            $this->_discountDescription = (string) $this->settings()->get(self::PRICE_SECTION, $this->getLangField('discountDescription'), '');
            $this->_discountDescription = nl2br(strip_tags($this->_discountDescription));
        }

        return $this->_discountDescription !== '';
    }

    /**
     * @return string
     */
    public function getDiscountDescription()
    {
        if (!$this->hasDiscountDescription()) {
            return '';
        }

        return strtr($this->_discountDescription, [
            '{{discount}}' => sprintf('<span>-%.0f%%</span>', $this->_discount * 100),
        ]);
    }

    /**
     * @param float $price Product price
     * @return float|int product price with discount ($price - N%)
     */
    public function calcDiscount($price, $category=false)
    {
        if (!$this->hasDiscount()) {
            return $this->calcPrice($price,$category);
        }

        return (1 - $this->_discount) * $this->calcPrice($price,$category);
    }

    /**
     * @param float $price
     * @return float|int
     */
    public function calcPrice($price,$category=false)
    {
        $this->_currencyRate = null;

        $rate = (float) $this->settings()->get(self::PRICE_SECTION, 'currencyRate', null);
        if ($this->_currencyRate === null) {
            
            if ($rate <= 0) {
                $this->_currencyRate = 1;
            } else {
                $this->_currencyRate = $rate;
            }
        }

        if ($category=='2000' || $category=='2001') {
            $this->_currencyRate = 1;   
        }

        $p = $this->_currencyRate * $price;
        return $p;
    }

    /**
     * @return Settings
     */
    protected function settings()
    {
        return Yii::$app->settings;
    }

    /**
     * @return Languages
     */
    protected function languagesComponent()
    {
        return Yii::$app->languages;
    }

    /**
     * @param string $field
     * @return string
     */
    protected function getLangField($field)
    {
        if (($language = $this->languagesComponent()->getCurrent()) === null) {
            return $field;
        }

        return $field . '_' . $language->getDatabaseCode();
    }
}