<?php

namespace common\models\shop;

use Yii;

/**
 * This is the model class for table "{{%images}}".
 *
 * @property string $url
 * @property string $size
 * @property int $downloaded
 * @property string $product_id
 * @property string $path
 *
 * @property Product $product
 */
class Image extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%images}}';
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
            'url' => 'Url',
            'size' => 'Size',
            'downloaded' => 'Downloaded',
            'product_id' => 'Product ID',
            'path' => 'Path',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }
}
