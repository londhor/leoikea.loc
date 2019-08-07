<?php

namespace common\models\shop;

use frontend\components\multilang\AttributeBehavior;
use Yii;

/**
 * This is the model class for table "{{%categories}}".
 *
 * @property int $id
 * @property string $title_pl
 * @property string $title_ru
 * @property string $title
 * @property string $url
 * @property string $slug
 * @property int $parent_id
 * @property string $parsed_at
 * @property string $icon
 *
 * @property string $titleLang
 *
 * @property Product[] $products
 * @property ProductUrl[] $productUrls
 * @property Category[] $subCategories
 * @property Category $parentCategory
 *
 * @method mixed lang(string $attribute)
 * @see AttributeBehavior::lang
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%categories}}';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->dbIkea;
    }

    /**
     * @inheritDoc
     * @return array
     */
    public function behaviors()
    {
        return [
            'multilang' => [
                'class' => AttributeBehavior::class,
                'attributes' => [
                    'title' => [
                        'template' => 'title_{{code}}',
                        'override' => ['uk-UA' => 'title'],
                        'default' => 'title_pl',
                    ],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title_pl' => 'Title Pl',
            'title_ru' => 'Title RU',
            'title' => 'Title',
            'url' => 'Url',
            'slug' => 'Slug',
            'parent_id' => 'Parent ID',
            'parsed_at' => 'Parsed At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubCategories()
    {
        return $this->hasMany(Category::class, ['parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::class, ['id' => 'product_id'])
            ->via('productToCategory');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParentCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductUrls()
    {
        return $this->hasMany(ProductUrl::class, ['category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductToCategory()
    {
        return $this->hasMany(ProductToCategory::class, ['category_id' => 'id']);
    }

    /**
     * @return string
     */
    public function getTitleLang()
    {
        return $this->lang('title');
    }
}
