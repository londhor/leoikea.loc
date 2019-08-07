<?php

namespace backend\forms;

use backend\assets\IconsAsset;
use yii;
use yii\base\Model;
use yii2mod\settings\components\Settings;
use yii2mod\settings\models\enumerables\SettingType;

class AdvantagesForm extends Model
{
    const SETTINGS_SECTION = 'advantages';
    const TYPE_JSON = 'json';

    /**
     * @var array
     */
    public $advantages_ru;

    /**
     * @var array
     */
    public $advantages_ua;

    /**
     * Load settings from component
     */
    public function init()
    {
        $this->advantages_ru = (array) $this->getSetting('advantages_ru', [], true);
        $this->advantages_ua = (array) $this->getSetting('advantages_ua', [], true);
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['advantages_ru', 'advantages_ua'], 'validateAdvantages', 'skipOnEmpty' => false],
        ];
    }

    /**
     * @param string $attribute
     * @param array $params
     * @return bool
     */
    public function validateAdvantages($attribute, $params)
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
                    'message' => 'Заповніть текст переваги',
                ]),
                'string' => new yii\validators\StringValidator([
                    'min' => 2,
                    'max' => 75,
                    'message' => 'Заповніть корректно текст переваги, від 2 до 75 символів',
                ]),
            ],
        ];

        $filters = [
            'label' => 'strip_tags',
        ];

        foreach ($list as $key => $value) {
            if (!is_array($value) || !isset($value['icon'], $value['label'])) {
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
    public function getIcons()
    {
        return IconsAsset::$icons;
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'advantages_ru' => 'Переваги [RU]',
            'advantages_ua' => 'Переваги [UA]',
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

        $this->setSetting('advantages_ru', $this->advantages_ru, self::TYPE_JSON);
        $this->setSetting('advantages_ua', $this->advantages_ua, self::TYPE_JSON);

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