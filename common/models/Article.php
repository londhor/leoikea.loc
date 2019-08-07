<?php

namespace common\models;

use dosamigos\transliterator\TransliteratorHelper;
use frontend\components\multilang\AttributeBehavior;
use frontend\components\multilang\LanguageInterface;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "{{%article}}".
 *
 * @property string $id
 * @property string $slug
 * @property string $title_ua [varchar(255)]
 * @property string $title_ru [varchar(255)]
 * @property string $meta_title_ua [varchar(255)]
 * @property string $meta_title_ru [varchar(255)]
 * @property string $meta_description_ua [varchar(500)]
 * @property string $meta_description_ru [varchar(500)]
 * @property string $body_ua
 * @property string $body_ru
 * @property string $updated_at
 * @property string $created_at
 *
 * @property string $titleLang
 * @property string $metaTitleLang
 * @property string $metaDescriptionLang
 * @property string $bodyLang
 *
 * @method mixed lang(string $attribute)
 * @method string|null getLangAttributeName(string $attribute, LanguageInterface $language = null)
 * @see AttributeBehavior::lang
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
            'multilang' => [
                'class' => AttributeBehavior::class,
                'attributes' => [
                    'title' => [
                        'template' => 'title_{{code}}',
                        'default' => 'title_ua',
                    ],
                    'meta_title' => [
                        'template' => 'meta_title_{{code}}',
                        'default' => 'meta_title_ua',
                    ],
                    'meta_description' => [
                        'template' => 'meta_description_{{code}}',
                        'default' => 'meta_description_ua',
                    ],
                    'body' => [
                        'template' => 'body_{{code}}',
                        'default' => 'body_ua',
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
            [['slug'], 'filter',
                'filter' => function ($value) {
                    return strtolower(preg_replace('/[^\w\_\-]/im', '', $value));
                }
            ],
            [['title_ua', 'meta_title_ua', 'meta_description_ua', 'title_ru', 'meta_title_ru', 'meta_description_ru'], 'filter',
                'filter' => 'strip_tags'
            ],
            [['body_ua', 'body_ru'], 'filter',
                'filter' => '\yii\helpers\HtmlPurifier::process',
            ],
            [['title_ua', 'body_ua', 'title_ru', 'body_ru'], 'required'],
            [['meta_description_ua', 'meta_description_ru'], 'string',
                'max' => 500
            ],
            [['body_ua', 'body_ru'], 'string'],
            [['title_ua', 'meta_title_ua', 'title_ru', 'meta_title_ru'], 'string',
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
            'title_ua' => 'Заголовок [UA]',
            'title_ru' => 'Заголовок [RU]',
            'meta_title_ua' => 'Meta Title [UA]',
            'meta_title_ru' => 'Meta Title [RU]',
            'meta_description_ua' => 'Meta Description [UA]',
            'meta_description_ru' => 'Meta Description [RU]',
            'body_ua' => 'Текст сторінки [UA]',
            'body_ru' => 'Текст сторінки [RU]',
            'updated_at' => 'Відновлено',
            'created_at' => 'Створено',
        ];
    }

    public function attributeHints()
    {
        return [
            'meta_title_ua' => '<code>{{site_name}}</code> - Назва сайту',
            'meta_title_ru' => '<code>{{site_name}}</code> - Назва сайту',
            'meta_description_ua' => '<code>{{site_name}}</code> - Назва сайту',
            'meta_description_ru' => '<code>{{site_name}}</code> - Назва сайту',
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
        $slug = TransliteratorHelper::process($this->titleLang);
        $slug = trim(preg_replace('/\W+/i', '-', $slug), '-');

        if ($useRandom) {
            $slug .= '-' . rand(1e5, 1e6-1);
        }

        return strtolower($slug);
    }

    /**
     * @return string|null
     */
    public function getTitleLang()
    {
        return $this->lang('title');
    }

    /**
     * @return string|null
     */
    public function getMetaTitleLang()
    {
        return $this->lang('meta_title');
    }

    /**
     * @return string|null
     */
    public function getMetaDescriptionLang()
    {
        return $this->lang('meta_description');
    }

    /**
     * @return string|null
     */
    public function getBodyLang()
    {
        return $this->lang('body');
    }
}
