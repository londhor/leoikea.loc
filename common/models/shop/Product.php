<?php

namespace common\models\shop;

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
        return strtotime($this->parsed_at) > strtotime('1 month ago');
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
        return $this->hasOne(Category::class, ['id' => 'category_id']);
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
        return $this->title === null ? $this->title_pl : $this->title;
    }

    /**
     * @return string
     */
    public function getDescrLang()
    {
        return $this->descr === null ? $this->descr_pl : $this->descr;
    }

    /**
     * @return string
     */
    public function getInfoLang()
    {
        return $this->info === null ? $this->info_pl : $this->info;
    }

    /**
     * @return string
     */
    public function getMaterialsLang()
    {
        return $this->materials === null ? $this->materials_pl : $this->materials;
    }

    /**
     * @return string
     */
    public function getPackageLang()
    {
        $package = $this->package === null ? $this->package_pl : $this->package;
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
