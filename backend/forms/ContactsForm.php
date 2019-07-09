<?php

namespace backend\forms;

use backend\assets\IconsAsset;
use yii;
use yii\base\Model;
use yii2mod\settings\components\Settings;
use yii2mod\settings\models\enumerables\SettingType;

class ContactsForm extends Model
{
    const SETTINGS_SECTION = 'contacts';
    const TYPE_JSON = 'json';

    /**
     * @var array
     */
    public $email;

    /**
     * @var array
     */
    public $phone;

    /**
     * @var array
     */
    public $address;

    /**
     * @var array
     */
    public $social;

    /**
     * @var string
     */
    public $reviewsLink;

    /**
     * Load settings from component
     */
    public function init()
    {
        $this->email = (array) $this->getSetting('email', [], true);
        $this->phone = (array) $this->getSetting('phone', [], true);
        $this->address = (array) $this->getSetting('address', [], true);
        $this->social = (array) $this->getSetting('social', [], true);
        $this->reviewsLink = (string) $this->getSetting('reviewsLink', '');
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['email'], 'validateEmails', 'skipOnEmpty' => false],
            [['phone'], 'validatePhones', 'skipOnEmpty' => false],
            [['address'], 'validateAddress', 'skipOnEmpty' => false],
            [['social'], 'validateSocial', 'skipOnEmpty' => false],
            [['reviewsLink'], 'string'],
        ];
    }

    /**
     * @param string $attribute
     * @param array $params
     * @return bool
     */
    public function validateEmails($attribute, $params)
    {
        $validators = [
            'required' => new yii\validators\RequiredValidator([
                'message' => 'Введіть Email',
            ]),
            'email' => new yii\validators\EmailValidator([
                'message' => 'Введіть коректний Email адрес'
            ]),
        ];

        return $this->eachValidator($attribute, $validators);
    }

    /**
     * @param string $attribute
     * @param array $params
     * @return bool
     */
    public function validatePhones($attribute, $params)
    {
        $validators = [
            'required' => new yii\validators\RequiredValidator([
                'message' => 'Введіть номер телефону',
            ]),
            'string' => new yii\validators\StringValidator([
                'max' => 15,
                'min' => 7,
                'message' => $message = 'Введіть номер телефону від 7 символів до 15',
                'tooLong' => $message,
                'tooShort' => $message,
            ]),
        ];

        $filter = function ($value) {
            return preg_replace('/[^0-9\+]/i', '', $value);
        };

        return $this->eachValidator($attribute, $validators, $filter);
    }

    /**
     * @param string $attribute
     * @param array $params
     * @return bool
     */
    public function validateAddress($attribute, $params)
    {
        $validators = [
            'required' => new yii\validators\RequiredValidator([
                'message' => 'Заповніть адресу'
            ]),
            'string' => new yii\validators\StringValidator([
                'max' => 255,
                'message' => $message = 'Адреса не повинна перевищувати 255 символів',
                'tooLong' => $message,
            ]),
        ];

        $filter = '\yii\helpers\HtmlPurifier::process';

        return $this->eachValidator($attribute, $validators, $filter);
    }

    /**
     * @param string $attribute
     * @param yii\validators\Validator[] $validators
     * @param \Closure|null $filter
     * @return bool
     */
    protected function eachValidator($attribute, $validators, $filter = null)
    {
        $list = $this->$attribute;

        if (!is_array($list)) {
            $this->$attribute = [];

            return true;
        }

        $valid = true;

        foreach ($list as $key => $value) {
            if (is_array($value) && isset($value[$attribute])) {
                $this->$attribute[$key] = $value = $value[$attribute];
            }

            if ($filter !== null && is_callable($filter)) {
                $this->$attribute[$key] = $value = call_user_func($filter, $value);
            }

            foreach ($validators as $validator) {
                $error = null;
                if (!$validator->validate($value, $error)) {
                    $this->addError($attribute . '.' . $key, $error);
                    $valid = false;
                }
            }
        }

        if (!$valid) {
            $this->addError($attribute, 'Введіть коректні дані');
        }

        return $valid;
    }

    /**
     * @param string $attribute
     * @param array $params
     * @return bool
     */
    public function validateSocial($attribute, $params)
    {
        $list = $this->$attribute;

        if (!is_array($list)) {
            $this->$attribute = [];

            return true;
        }

        $valid = true;

        $validators = [
            'icon' => [
                'required' => new yii\validators\RequiredValidator([
                    'message' => 'Віберіть іконку',
                ]),
                'range' => new yii\validators\RangeValidator([
                    'range' => array_keys(IconsAsset::$icons),
                    'message' => 'Ви не маєте можливості вибрати цю іконку',
                ]),
            ],
            'label' => [
                'required' => new yii\validators\RequiredValidator([
                    'message' => 'Заповніть позначку',
                ]),
                'string' => new yii\validators\StringValidator([
                    'min' => 2,
                    'max' => 25,
                    'message' => 'Заповніть позначку корректно, від 2 до 25 символів',
                ]),
            ],
            'link' => [
                'required' => new yii\validators\RequiredValidator([
                    'message' => 'Заповніть посилання',
                ]),
                'string' => new yii\validators\StringValidator(),
            ],
        ];

        $filters = [
            'label' => 'strip_tags',
            'link' => 'strip_tags',
        ];

        foreach ($list as $key => $value) {
            if (!is_array($value) || !isset($value['icon'], $value['label'], $value['link'])) {
                $this->$attribute = [];
                return false;
            }

            $values = [];

            foreach ($validators as $attr => $attrValidators) {
                if (isset($filters[$attr]) && is_callable($filters[$attr])) {
                    $values[$attr] = call_user_func($filters[$attr], (string) $value[$attr]);
                } else {
                    $values[$attr] = (string) $value[$attr];
                }

                foreach ($attrValidators as $validator) {
                    $error = null;
                    if (!$validator->validate($values[$attr], $error)) {
                        $this->addError($attribute . '.' . $key . '.' . $attr, $error);
                        $valid = false;
                    }
                }
            }

            $this->$attribute[$key] = $values;
        }

        if (!$valid) {
            $this->addError($attribute, 'Введіть коректні дані');
        }

        return $valid;
    }

    /**
     * @return array
     */
    public function getSocialIcons()
    {
        return IconsAsset::$icons;
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'phone' => 'Телефони',
            'email' => 'Email адреса',
            'address' => 'Фізичні адреса',
            'social' => 'Соціальні мережі',
            'reviewsLink' => 'Посилання на всі відгуки',
        ];
    }

    /**
     * @param bool $validate
     * @return bool
     */
    public function store($validate = true)
    {
        if ($validate && !$this->validate()) {
            return false;
        }

        $this->setSetting('email', $this->email, self::TYPE_JSON);
        $this->setSetting('phone', $this->phone, self::TYPE_JSON);
        $this->setSetting('address', $this->address, self::TYPE_JSON);
        $this->setSetting('social', $this->social, self::TYPE_JSON);
        $this->setSetting('reviewsLink', $this->reviewsLink, SettingType::STRING_TYPE);

        return true;
    }

    /**
     * @param string $name
     * @param mixed $default
     * @param bool $isJson
     * @return mixed
     */
    protected function getSetting($name, $default = null, $isJson = false)
    {
        $settings = Yii::$app->settings;
        $value = $settings->get(self::SETTINGS_SECTION, $name, $default);

        if ($isJson && is_string($value)) {
            $value = json_decode($value, true);
            if ($value === false) {
                $value = $default;
            }
        }

        return $value;
    }

    /**
     * @param string $name
     * @param mixed $value
     * @param string|null $type
     * @return bool
     */
    protected function setSetting($name, $value, $type = null)
    {
        /** @var Settings $settings */
        $settings = Yii::$app->settings;

        if ($type === self::TYPE_JSON) {
            $value = json_encode($value);
            $type = SettingType::STRING_TYPE;
        }

        return $settings->set(self::SETTINGS_SECTION, $name, $value, $type);
    }
}