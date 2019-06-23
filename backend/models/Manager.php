<?php

namespace backend\models;

use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii;

/**
 * Class Manager
 * @package backend\models
 *
 * @property int $id [int(10) unsigned]
 * @property string $name [varchar(45)]
 * @property string $email [varchar(255)]
 * @property string $auth_key [varchar(64)]
 * @property string $password_hash [varchar(60)]
 * @property string $updated_at [timestamp]
 * @property string $created_at [timestamp]
 */
class Manager extends ActiveRecord implements yii\web\IdentityInterface
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%manager}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => yii\behaviors\TimestampBehavior::class,
                'value' => new yii\db\Expression('NOW()'),
            ],
        ];
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['name', 'email'], 'required'],
            [['email'], 'email'],
            [['email'], 'unique'],
            [['name'], 'string', 'min' => 2, 'max' => 45],
        ];
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            return true;
        }

        return false;
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Имя',
            'email' => 'Email',
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * {@inheritdoc}
     * @throws NotSupportedException
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * @param string $email
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return static::findOne(
            ['email' => $email]
        );
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    /**
     * @throws \yii\base\Exception
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString(64);
    }

    /**
     * @param string $password
     * @return bool
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * @param $password
     * @throws \yii\base\Exception
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }
}
