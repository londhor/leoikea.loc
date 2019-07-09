<?php

namespace frontend\components;

use common\models\Article;
use common\models\shop\Category;
use common\models\shop\Product;
use yii;
use yii2mod\settings\components\Settings;

/**
 * Component for generate page meta fields
 */
class MetaFieldsSettings extends \yii\base\Component
{
    const META_FIELDS_SECTION = 'metaFields';

    public $defaultForProduct = '{{title}}. {{description}} - {{category}} | {{site_name}}';

    public $defaultForHome = 'Головна сторінка | {{site_name}}';

    public $defaultForCatalog = 'Каталог товарів | {{site_name}}';

    public $defaultForContacts = 'Контакти | {{site_name}}';

    public $defaultForCategory = '{{title}} | {{site_name}}';

    public $defaultForSearch = 'Пошук "{{query}}" | {{site_name}}';

    public $defaultForInformation = '{{meta}}';

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
            $price = Yii::$app->formatter->asCurrency($priceSettings->calcDiscount($product->price));
        } catch (yii\base\InvalidConfigException $e) {
            $price = $priceSettings->calcDiscount($product->price);
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
            '{{meta}}' => $article->meta_title ? strtr($article->meta_title, $this->mergeDefaultParams([])) : $article->title,
        ]);
        $this->registerDescription($meta_description, [
            '{{meta}}' => $article->meta_description ? strtr($article->meta_description, $this->mergeDefaultParams([])) : $article->title,
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
            'content' => yii\helpers\Html::encode($description),
        ]);
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

        Yii::$app->view->title = yii\helpers\Html::encode($title);
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
        /** @var Settings $settings */
        $settings = Yii::$app->settings;
        $field = $settings->get(self::META_FIELDS_SECTION, $name, $default);

        if (!is_string($field) || $field === '') {
            return $default;
        }

        return $field;
    }
}