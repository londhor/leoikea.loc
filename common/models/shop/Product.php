<?php

namespace common\models\shop;

use frontend\components\multilang\AttributeBehavior;
use Yii;
use yii2tech\filestorage\BucketInterface;

/**
 * This is the model class for table "{{%products}}".
 *
 * @property string $id
 * @property string $title_pl
 * @property string $title_ru [varchar(255)]
 * @property string $title
 * @property string $descr_pl
 * @property string $descr_ru [varchar(255)]
 * @property string $descr
 * @property string $article
 * @property int $category_id
 * @property string $price
 * @property string $old_price [decimal(10,2)]
 * @property string $info_pl
 * @property string $info_ru
 * @property string $info
 * @property string $materials_pl
 * @property string $materials_ru
 * @property string $materials
 * @property string $package_pl
 * @property string $package_ru
 * @property string $package
 * @property string $variations_pl
 * @property string $variations_ru
 * @property string $variations
 * @property string $variations_headings_pl
 * @property string $variations_headings_ru
 * @property string $variations_headings
 * @property string $parsed_at
 * @property int $views
 *
 *
 * @property string $titleLang
 * @property string $descrLang
 * @property string $infoLang
 * @property string $packageLang
 * @property string $materialsLang
 * @property string $productName
 * @property float|int $priceInCurrency
 *
 * @property Documentation[] $documentations
 * @property Image[] $images
 * @property Image[] $imagesZoom
 * @property Image $image
 * @property Category $category
 * @property Category[] $categories
 * @property ProductToCategory $productToCategory
 *
 * @method mixed lang(string $attribute)
 * @see AttributeBehavior::lang
 */
class Product extends \yii\db\ActiveRecord
{
    const CURRENCY_RATE = 12;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%products}}';
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
                    'descr' => [
                        'template' => 'descr_{{code}}',
                        'override' => ['uk-UA' => 'descr'],
                        'default' => 'descr_pl',
                    ],
                    'info' => [
                        'template' => 'info_{{code}}',
                        'override' => ['uk-UA' => 'info'],
                        'default' => 'info_pl',
                    ],
                    'materials' => [
                        'template' => 'materials_{{code}}',
                        'override' => ['uk-UA' => 'materials'],
                        'default' => 'materials_pl',
                    ],
                    'package' => [
                        'template' => 'package_{{code}}',
                        'override' => ['uk-UA' => 'package'],
                        'default' => 'package_pl',
                    ],
                    'variations' => [
                        'template' => 'variations_{{code}}',
                        'override' => ['uk-UA' => 'variations'],
                        'default' => 'variations_pl',
                    ],
                    'variations_headings' => [
                        'template' => 'variations_headings_{{code}}',
                        'override' => ['uk-UA' => 'variations_headings'],
                        'default' => 'variations_headings_pl',
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
            'descr_pl' => 'Descr Pl',
            'descr' => 'Descr',
            'article' => 'Article',
            'category_id' => 'Category ID',
            'price' => 'Price',
            'info_pl' => 'Info Pl',
            'info' => 'Info',
            'materials_pl' => 'Materials Pl',
            'materials' => 'Materials',
            'package_pl' => 'Package Pl',
            'package' => 'Package',
            'variations_pl' => 'Variations Pl',
            'variations' => 'Variations',
            'variations_headings_pl' => 'Variations Headings Pl',
            'variations_headings' => 'Variations Headings',
            'parsed_at' => 'Parsed At',
        ];
    }

    /**
     * @return bool
     */
    public function isNewProduct()
    {
        return strtotime($this->parsed_at) > strtotime('2 weeks ago');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocumentations()
    {
        return $this->hasMany(Documentation::class, ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImages()
    {
        return $this->hasMany(Image::class, ['product_id' => 'id'])
            ->andOnCondition(['size' => 'zoom'])
            ->andOnCondition(['downloaded' => true])
            ->orderBy(['display_order' => SORT_ASC]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImagesZoom()
    {
        return $this->hasMany(Image::class, ['product_id' => 'id'])
            ->andOnCondition(['size' => 'large'])
            ->andOnCondition(['downloaded' => true])
            ->orderBy(['display_order' => SORT_ASC]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id'])
            ->via('productToCategory');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Category::class, ['id' => 'category_id'])
            ->via('productToCategory');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductToCategory()
    {
        return $this->hasMany(ProductToCategory::class, ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImage()
    {
        return $this->hasOne(Image::class, ['product_id' => 'id'])
            ->andOnCondition(['size' => 'large'])
            ->andOnCondition(['downloaded' => true])
            ->orderBy(['display_order' => SORT_ASC]);
    }

    /**
     * @return BucketInterface
     */
    public function bucket()
    {
        return Yii::$app->fileStorage->getBucket('products');
    }

    /**
     * @return string
     */
    public function getTitleLang()
    {
        return $this->lang('title');
    }

    /**
     * @return string
     */
    public function getDescrLang()
    {
        return $this->lang('descr');
    }

    /**
     * @return string
     */
    public function getInfoLang()
    {
        return $this->lang('info');
    }

    /**
     * @return string
     */
    public function getMaterialsLang()
    {
        return $this->lang('materials');
    }

    /**
     * @return string
     */
    public function getPackageLang()
    {
        $package = $this->lang('package');
        if ($package === null) {
            return null;
        }

        $package = json_decode($package, true);
        if (!is_array($package)) {
            return null;
        }

        return $package;
    }

    /**
     * @return string
     */
    public function getProductName()
    {
        return sprintf('%s. %s', $this->titleLang, $this->descrLang);
    }

    /**
     * @return float|int
     */
    public function getPriceInCurrency()
    {
        return $this->price * self::CURRENCY_RATE;
    }
}
