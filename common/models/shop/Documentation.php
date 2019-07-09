<?php

namespace common\models\shop;

use Yii;

/**
 * This is the model class for table "{{%documentations}}".
 *
 * @property int $id
 * @property string $title_pl
 * @property string $title
 * @property string $url
 * @property string $product_id
 * @property string $title_ru [varchar(255)]
 *
 * @property string $titleLang
 *
 * @property Product $product
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
        return $this->title === null ? $this->title_pl : $this->title;
    }
}
