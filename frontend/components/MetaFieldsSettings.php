<?php

namespace frontend\components;

use common\models\Article;
use common\models\shop\Category;
use common\models\shop\Product;
use frontend\components\multilang\Languages;
use yii;
use yii2mod\settings\components\Settings;

/**
 * Component for generate page meta fields
 */
class MetaFieldsSettings extends \yii\base\Component
{
    const META_FIELDS_SECTION = 'metaFields';

    public $defaultForProduct;

    public $defaultForHome;

    public $defaultForCatalog;

    public $defaultForContacts;

    public $defaultForCategory;

    public $defaultForSearch;

    public $defaultForInformation;

    public function init()
    {
        if ($this->defaultForProduct === null) {
            $this->defaultForProduct = Yii::t('app/metafields', '{{title}}. {{description}} - {{category}} | {{site_name}}');
        }
        if ($this->defaultForHome === null) {
            $this->defaultForHome = Yii::t('app/metafields', 'Головна сторінка | {{site_name}}');
        }
        if ($this->defaultForCatalog === null) {
            $this->defaultForCatalog = Yii::t('app/metafields', 'Каталог товарів | {{site_name}}');
        }
        if ($this->defaultForContacts === null) {
            $this->defaultForContacts = Yii::t('app/metafields', 'Контакти | {{site_name}}');
        }
        if ($this->defaultForCategory === null) {
            $this->defaultForCategory = Yii::t('app/metafields', '{{title}} | {{site_name}}');
        }
        if ($this->defaultForSearch === null) {
            $this->defaultForSearch = Yii::t('app/metafields', 'Пошук "{{query}}" | {{site_name}}');
        }
        if ($this->defaultForInformation === null) {
            $this->defaultForInformation = Yii::t('app/metafields', '{{meta}}');
        }
    }

    /**
     * @param Product $product
     */
    public function generateForProduct($product)
    {
        $meta_title = $this->getField('productTitle', $this->defaultForProduct);
        $meta_description = $this->getField('productDescription', '');

        /** @var PriceSettings $priceSettings */
        $priceSettings = Yii::$app->priceSettings;

        try {
            $price = Yii::$app->formatter->asCurrency($priceSettings->calcDiscount($product->price, $product->category->id));
        } catch (yii\base\InvalidConfigException $e) {
            $price = $priceSettings->calcDiscount($product->price,$product->category->id);
        }


        $params = [
            '{{title}}' => $product->titleLang,
            '{{description}}' => $product->descrLang,
            '{{price}}' => $price,
            '{{category}}' => $product->category === null ? '' : $product->category->titleLang,
        ];

        $this->registerTitle($meta_title, $params);
        $this->registerDescription($meta_description, $params);
    }

    public function generateForHome()
    {
        $meta_title = $this->getField('homeTitle', $this->defaultForHome);
        $meta_description = $this->getField('homeDescription', '');

        $this->registerTitle($meta_title);
        $this->registerDescription($meta_description);
    }

    public function generateForContacts()
    {
        $meta_title = $this->getField('contactsTitle', $this->defaultForContacts);
        $meta_description = $this->getField('contactsDescription', '');

        $this->registerTitle($meta_title);
        $this->registerDescription($meta_description);
    }

    /**
     * @param Article $article
     */
    public function generateForInformation($article)
    {
        $meta_title = $this->getField('informationTitle', $this->defaultForInformation);
        $meta_description = $this->getField('informationTitle', '');

        $this->registerTitle($meta_title, [
            '{{meta}}' => ($field = $article->metaTitleLang) ? strtr($field, $this->mergeDefaultParams([])) : $article->titleLang,
        ]);
        $this->registerDescription($meta_description, [
            '{{meta}}' => ($field = $article->metaDescriptionLang) ? strtr($field, $this->mergeDefaultParams([])) : $article->titleLang,
        ]);
    }

    /**
     * @param Category $category
     */
    public function generateForCategory($category)
    {
        $meta_title = $this->getField('categoryTitle', $this->defaultForCategory);
        $meta_description = $this->getField('categoryDescription', '');

        $params = [
            '{{title}}' => $category->titleLang,
        ];

        $this->registerTitle($meta_title, $params);
        $this->registerDescription($meta_description, $params);
    }

    /**
     * @param string $query
     */
    public function generateForSearch($query)
    {
        $meta_title = $this->getField('searchTitle', $this->defaultForSearch);
        $meta_description = $this->getField('searchDescription', '');

        $params = [
            '{{query}}' => $query,
        ];

        $this->registerTitle($meta_title, $params);
        $this->registerDescription($meta_description, $params);
    }

    public function generateForCatalog()
    {
        $meta_title = $this->getField('catalogTitle', $this->defaultForCatalog);
        $meta_description = $this->getField('catalogDescription', '');

        $this->registerTitle($meta_title);
        $this->registerDescription($meta_description);
    }

    /**
     * @param string $description
     * @param array $params
     * @return void
     */
    public function registerDescription($description, $params = [])
    {
        if ($description === '') {
            return;
        }

        $description = strtr($description, $this->mergeDefaultParams($params));

        Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => $description,
        ]);
        // Yii::$app->view->registerMetaTag([
            // 'property' => 'og:description',
            // 'content' => $description,
        // ]);
    }

    /**
     * @param string $title
     * @param array $params
     */
    public function registerTitle($title, $params = [])
    {
        if ($title === '') {
            return;
        }

        $title = strtr($title, $this->mergeDefaultParams($params));
        Yii::$app->view->title = $title;
    }

    /**
     * @param array $params
     * @return array
     */
    protected function mergeDefaultParams($params)
    {
        return yii\helpers\ArrayHelper::merge([
            '{{site_name}}' => Yii::$app->name,
        ], $params);
    }

    /**
     * @param string $name
     * @param string $default
     * @return mixed
     */
    protected function getField($name, $default = '')
    {
        /** @var Languages $languagesComponent */
        $languagesComponent = Yii::$app->languages;
        if (($language = $languagesComponent->getCurrent()) !== null) {
            $name .= '_' . $language->getDatabaseCode();
        }

        /** @var Settings $settings */
        $settings = Yii::$app->settings;
        $field = $settings->get(self::META_FIELDS_SECTION, $name, $default);

        if (!is_string($field) || $field === '') {
            return $default;
        }

        return $field;
    }
}