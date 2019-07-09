<?php

namespace common\models;

use dosamigos\transliterator\TransliteratorHelper;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "{{%article}}".
 *
 * @property string $id
 * @property string $slug
 * @property string $title
 * @property string $meta_title
 * @property string $meta_description
 * @property string $body
 * @property string $updated_at
 * @property string $created_at
 */
class Article extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%article}}';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['slug'], 'filter',
                'filter' => function ($value) {
                    return strtolower(preg_replace('/[^\w\_\-]/im', '', $value));
                }
            ],
            [['title', 'meta_title', 'meta_description'], 'filter',
                'filter' => 'strip_tags'
            ],
            [['body'], 'filter',
                'filter' => '\yii\helpers\HtmlPurifier::process',
            ],
            [['title', 'body'], 'required'],
            [['meta_description'], 'string',
                'max' => 500
            ],
            [['body'], 'string'],
            [['title', 'meta_title'], 'string',
                'max' => 255
            ],
            [['slug'], 'string',
                'max' => 100
            ],
            [['slug'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'slug' => 'Аліас',
            'title' => 'Заголовок',
            'meta_title' => 'Meta Title',
            'meta_description' => 'Meta Description',
            'body' => 'Текст сторінки',
            'updated_at' => 'Відновлено',
            'created_at' => 'Створено',
        ];
    }

    public function attributeHints()
    {
        return [
            'meta_title' => '<code>{{site_name}}</code> - Назва сайту',
            'meta_description' => '<code>{{site_name}}</code> - Назва сайту',
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->slug === '' || $this->slug === null) {
                $this->slug = $this->generateAlias();

                while (Article::find()
                        ->where(['slug' => $this->slug])
                        ->andWhere($this->isNewRecord ? 1 : ['!=', 'id', $this->id])
                        ->count() > 0) {
                    $this->slug = $this->generateAlias(true);
                }
            }

            return true;
        }

        return false;
    }

    /**
     * @param bool $useRandom
     * @return string
     */
    private function generateAlias($useRandom = false)
    {
        $slug = TransliteratorHelper::process($this->title);
        $slug = trim(preg_replace('/\W+/i', '-', $slug), '-');

        if ($useRandom) {
            $slug .= '-' . rand(1e5, 1e6-1);
        }

        return strtolower($slug);
    }
}
