<?php

namespace common\models\shop;

use Yii;

/**
 * This is the model class for table "{{%products_urls}}".
 *
 * @property int $id
 * @property string $url
 * @property int $category_id
 * @property string $parsed_at
 *
 * @property Category $category
 */
class ProductUrl extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%products_urls}}';
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
            'url' => 'Url',
            'category_id' => 'Category ID',
            'parsed_at' => 'Parsed At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }
}
