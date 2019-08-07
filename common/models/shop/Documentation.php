<?php

namespace common\models\shop;

use frontend\components\multilang\AttributeBehavior;
use Yii;

/**
 * This is the model class for table "{{%documentations}}".
 *
 * @property string $title_pl [varchar(255)]
 * @property string $title_ru [varchar(255)]
 * @property string $title [varchar(255)]
 * @property string $url
 * @property string $product_id
 *
 * @property string $titleLang
 *
 * @property Product $product
 *
 * @method mixed lang(string $attribute)
 * @see AttributeBehavior::lang
 */
class Documentation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%documentations}}';
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
            'title' => 'Title',
            'url' => 'Url',
            'product_id' => 'Product ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }

    /**
     * @return string
     */
    public function getTitleLang()
    {
        return $this->lang('title');
    }
}
