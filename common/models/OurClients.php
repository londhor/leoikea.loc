<?php

namespace common\models;

use common\components\UploadTrait;
use yii;
use yii\web\UploadedFile;
use yii2tech\filestorage\BucketInterface;

/**
 * This is the model class for table "{{%our_clients}}".
 *
 * @property string $id
 * @property string $image
 * @property int $sort_order
 *
 * @property-read string|null $imageUrl
 */
class OurClients extends yii\db\ActiveRecord
{
    use UploadTrait;

    /**
     * @inheritdoc
     */
    public function load($data, $formName = null)
    {
        if (parent::load($data, $formName)) {
            $this->upload = UploadedFile::getInstance($this, 'upload');

            return true;
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%our_clients}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sort_order'], 'integer'],
            [['upload'], 'image',
                'extensions' => ['jpg', 'png'],
                'mimeTypes' => ['image/jpeg', 'image/jpg', 'image/png'],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'image' => 'Зображення',
            'upload' => 'Зображення',
            'sort_order' => 'Порядок',
        ];
    }

    /**
     * @return bool
     */
    public function beforeValidate()
    {
        if (!parent::beforeValidate()) {
            return false;
        }

        if ($this->hasErrors('upload')) {
            return false;
        }

        if (!$this->upload instanceof UploadedFile && $this->image === null) {
            $this->addError('upload', 'Необхідно завантажити зображення');

            return false;
        }

        return true;
    }

    /**
     * @return BucketInterface
     */
    public function bucket()
    {
        return Yii::$app->fileStorage->getBucket('our_clients');
    }

    /**
     * @return null|string
     */
    public function getImageUrl()
    {
        if ($this->image !== null) {
            return $this->bucket()->getFileUrl($this->image);
        }

        return null;
    }

    /**
     * @inheritdoc
     */
    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            $this->deleteImage();

            return true;
        }

        return false;
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        if (!$this->uploadImage()) {
            $this->addError('upload', 'Не удалось загрзуить изображение');

            return false;
        }

        $this->generateSortOrder();

        return true;
    }

    /**
     * @return bool
     */
    public function generateSortOrder()
    {
        if ($this->sort_order === '' || $this->sort_order === null) {
            $max = OurClients::find()->max('sort_order');
            $this->sort_order = $max === null ? 0 : $max + 1;
        }

        return true;
    }
}