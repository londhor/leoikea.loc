<?php

namespace common\components;

use yii;
use yii2tech\filestorage\BucketInterface;

/**
 * Trait UploadTrait
 * @property string|null $image
 * @method BucketInterface bucket()
 * @package common\components
 */
trait UploadTrait
{
    /**
     * @var null|yii\web\UploadedFile
     */
    public $upload;

    /**
     * @var boolean
     */
    public $deleteImage;

    /**
     * Delete image
     */
    public function deleteImage()
    {
        if ($this->image !== null && $this->image !== '') {
            $this->bucket()->deleteFile($this->image);
        }
    }

    /**
     * @return bool
     */
    public function uploadImage()
    {
        if ($this->upload === null) {
            if ($this->deleteImage) {
                $this->deleteImage();
            }

            return true;
        }

        try {
            $format = $this->upload->extension;
            $imageName = Yii::$app->security->generateRandomString() . '.' . $format;
            $imageName = strtolower(preg_replace('/[\-_]+/i', '-', $imageName));

            $runtimePath = Yii::getAlias('@runtime/tmp/');
            yii\helpers\FileHelper::createDirectory($runtimePath);
            $runtimePath = $runtimePath . $imageName;

            if (!$this->upload->saveAs($runtimePath)) {
                return false;
            }
        } catch (yii\base\Exception $e) {
            return false;
        }

        $this->deleteImage();
        $this->image = $imageName;

        $this->bucket()->copyFileIn($runtimePath, $imageName);

        unlink($runtimePath);

        return true;
    }
}